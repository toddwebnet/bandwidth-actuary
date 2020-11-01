<?php

namespace App\Services;

use App\Jobs\AddToReportJob;
use App\Jobs\ProcessFileJob;
use App\Jobs\TrafficImportJob;
use App\Models\Traffic;
use Illuminate\Support\Facades\Log;

class TrafficImportService
{

    private $files = [
        'log.1.0.cdf',
        'log.1.1.cdf',
        'log.1.2.cdf',
        'log.1.3.cdf',
        'log.1.4.cdf',
        'log.1.5.cdf',
    ];

    public function importFromPfSense()
    {
        $importPath = storage_path() . '/imports';
        $this->importFiles($importPath);
        foreach ($this->files as $file) {
            QueueService::instance()
                ->sendToQueue(ProcessFileJob::class, [
                    'filePath' => $importPath . '/' . $file
                ]);
        }
    }

    public function processFile($filePath)
    {
        Log::info("Processing File: {$filePath}");
        /** @var QueueService $queueService */
        $queueService = app()->make(QueueService::class);
        $file = fopen($filePath, 'r');
        while (!feof($file)) {
            $row = trim(fgets($file));
            if (strlen($row > 0)) {
                $queueService->sendToQueue(TrafficImportJob::class, [
                    'row' => $row
                ], 'import');
            }

        }
        fclose($file);
    }

    private function importFiles($importPath)
    {
        $cmd = 'rm -f ' . $importPath . '/*.cdf';
        exec($cmd);

        $username = env("PFSENSE_USERNAME");
        $password = env("PFSENSE_PASSWORD");
        $hostName = env("PFSENSE_HOSTNAME");
        $sourcePath = env("CDF_FILE_PATH");

        foreach ($this->files as $file) {
            $cmd = "sshpass -p \"{$password}\" scp {$username}@{$hostName}:{$sourcePath}/{$file} {$importPath}/{$file}";
            exec($cmd);
        }
    }

    public function processImportRow($row)
    {
        $data = explode(',', $row);
        $keys = [
            'ip',
            'timestamp',
            'total_sent',
            'icmp_sent',
            'udp_sent',
            'tcp_sent',
            'ftp_sent',
            'http_sent',
            'p2p_sent',
            'total_rec',
            'icmp_rec',
            'udp_rec',
            'tcp_rec',
            'ftp_rec',
            'http_rec',
            'p2p_rec',
        ];
        if (count($data) != count($keys)) {
            Log::alert('Invalid row: ' . json_encode([$data]));
            throw new \Exception('Invalid Data Row');
        }
        $traffic = [];
        foreach ($keys as $i => $key) {
            $traffic[$key] = $data[$i];
        }
        if (!Traffic::exists($traffic['ip'], $traffic['timestamp'])) {
            $traffic = Traffic::create($traffic);
            QueueService::instance()->sendToQueue(AddToReportJob::class, [
                'id' => $traffic->id
            ], 'compile');
        }

    }
}
