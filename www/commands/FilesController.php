<?php

namespace app\commands;

use yii\console\Controller;
use app\components\AppComp;
use yii\helpers\Console;

class FilesController extends Controller
{
    const OS_LINUX = 'Linux';
    const OS_MAC = 'Mac OS X';
    const OS_WIN = 'Windows';
    
    const ARCH_32 = '32';
    const ARCH_64 = '64';
    
    const PROCESSOR_CPU = 'CPU';
    const PROCESSOR_GPU = 'GPU';
    
    const TYPE_CLIENT = 'Client';
    const TYPE_VENDOR = 'Vendor';
    
    public static $os = [
        self::OS_LINUX => self::OS_LINUX,
        self::OS_MAC => self::OS_MAC,
        self::OS_WIN => self::OS_WIN
    ];
    
    public static $arch = [
        self::ARCH_32 => self::ARCH_32,
        self::ARCH_64 => self::ARCH_64
    ];
    
    public static $processor = [
        self::PROCESSOR_CPU => self::PROCESSOR_CPU,
        self::PROCESSOR_GPU => self::PROCESSOR_GPU
    ];
    
    public static $file_type = [
        self::TYPE_CLIENT => self::TYPE_CLIENT,
        self::TYPE_VENDOR => self::TYPE_VENDOR
    ];
    
    public function actionSync()
    {
        $pathOfClient               = 'd-bf' . DIRECTORY_SEPARATOR;
        $pathOfVendorCudaHashcat    = 'vendor' . DIRECTORY_SEPARATOR . 'cudaHashcat' . DIRECTORY_SEPARATOR;
        $pathOfVendorOclHashcat     = 'vendor' . DIRECTORY_SEPARATOR . 'oclHashcat' . DIRECTORY_SEPARATOR;
        $pathOfVendorHashcat        = 'vendor' . DIRECTORY_SEPARATOR . 'hashcat' . DIRECTORY_SEPARATOR;

//          sort,   file_type,  name,           os,             arch,           processor,              brand,      path
//          0       1           2               3               4               5                       6           7
        $files = [
            ['0',   self::TYPE_CLIENT,  'D-BF',         self::OS_LINUX, self::ARCH_32,  self::PROCESSOR_CPU,    '',         $pathOfClient.'linux_32.7z'],
            ['0',   self::TYPE_CLIENT,  'D-BF',         self::OS_LINUX, self::ARCH_64,  self::PROCESSOR_CPU,    '',         $pathOfClient.'linux_64.7z'],
            ['0',   self::TYPE_CLIENT,  'D-BF',         self::OS_MAC,   self::ARCH_32,  self::PROCESSOR_CPU,    '',         $pathOfClient.'mac_32.7z'],
            ['0',   self::TYPE_CLIENT,  'D-BF',         self::OS_MAC,   self::ARCH_64,  self::PROCESSOR_CPU,    '',         $pathOfClient.'mac_64.7z'],
            ['0',   self::TYPE_CLIENT,  'D-BF',         self::OS_WIN,   self::ARCH_32,  self::PROCESSOR_CPU,    '',         $pathOfClient.'windows_32.7z'],
            ['0',   self::TYPE_CLIENT,  'D-BF',         self::OS_WIN,   self::ARCH_64,  self::PROCESSOR_CPU,    '',         $pathOfClient.'windows_64.7z'],
            
            ['1',   self::TYPE_VENDOR,  'cudaHashcat',  self::OS_LINUX, self::ARCH_32,  self::PROCESSOR_GPU,    'Nvidia',   $pathOfVendorCudaHashcat.'gpu_linux_32_nv.7z'],
            ['1',   self::TYPE_VENDOR,  'cudaHashcat',  self::OS_LINUX, self::ARCH_64,  self::PROCESSOR_GPU,    'Nvidia',   $pathOfVendorCudaHashcat.'gpu_linux_64_nv.7z'],
            ['1',   self::TYPE_VENDOR,  'cudaHashcat',  self::OS_WIN,   self::ARCH_32,  self::PROCESSOR_GPU,    'Nvidia',   $pathOfVendorCudaHashcat.'gpu_win_32_nv.7z'],
            ['1',   self::TYPE_VENDOR,  'cudaHashcat',  self::OS_WIN,   self::ARCH_64,  self::PROCESSOR_GPU,    'Nvidia',   $pathOfVendorCudaHashcat.'gpu_win_64_nv.7z'],
            
            ['1',   self::TYPE_VENDOR,  'oclHashcat',   self::OS_LINUX, self::ARCH_32,  self::PROCESSOR_GPU,    'AMD',      $pathOfVendorOclHashcat.'gpu_linux_32_amd.7z'],
            ['1',   self::TYPE_VENDOR,  'oclHashcat',   self::OS_LINUX, self::ARCH_64,  self::PROCESSOR_GPU,    'AMD',      $pathOfVendorOclHashcat.'gpu_linux_64_amd.7z'],
            ['1',   self::TYPE_VENDOR,  'oclHashcat',   self::OS_WIN,   self::ARCH_32,  self::PROCESSOR_GPU,    'AMD',      $pathOfVendorOclHashcat.'gpu_win_32_amd.7z'],
            ['1',   self::TYPE_VENDOR,  'oclHashcat',   self::OS_WIN,   self::ARCH_64,  self::PROCESSOR_GPU,    'AMD',      $pathOfVendorOclHashcat.'gpu_win_64_amd.7z'],
            
            ['2',   self::TYPE_VENDOR,  'hashcat',      self::OS_LINUX, self::ARCH_32,  self::PROCESSOR_CPU,    '',         $pathOfVendorHashcat.'cpu_linux_32.7z'],
            ['2',   self::TYPE_VENDOR,  'hashcat',      self::OS_LINUX, self::ARCH_64,  self::PROCESSOR_CPU,    '',         $pathOfVendorHashcat.'cpu_linux_64.7z'],
            ['2',   self::TYPE_VENDOR,  'hashcat',      self::OS_MAC,   self::ARCH_64,  self::PROCESSOR_CPU,    '',         $pathOfVendorHashcat.'cpu_mac_64.7z'],
            ['2',   self::TYPE_VENDOR,  'hashcat',      self::OS_WIN,   self::ARCH_32,  self::PROCESSOR_CPU,    '',         $pathOfVendorHashcat.'cpu_win_32.7z'],
            ['2',   self::TYPE_VENDOR,  'hashcat',      self::OS_WIN,   self::ARCH_64,  self::PROCESSOR_CPU,    '',         $pathOfVendorHashcat.'cpu_win_64.7z']
        ];
        
        $path = AppComp::getPublicPath() . 'last' . DIRECTORY_SEPARATOR;
        
        $values = '';
        $params = [];
        $i = 0;
        foreach ($files as $fileInfo) {
            if (file_exists($path . $fileInfo[7])) {
                $values .= ",(:i0$i, :i1$i, :i2$i, :i3$i, :i4$i, :i5$i, :i6$i, :i7$i, :i8$i, :i9$i)";
                
                $params[":i0$i"] = $fileInfo[0];
                $params[":i1$i"] = $fileInfo[1];
                $params[":i2$i"] = $fileInfo[2];
                $params[":i3$i"] = $fileInfo[3];
                $params[":i4$i"] = $fileInfo[4];
                $params[":i5$i"] = $fileInfo[5];
                $params[":i6$i"] = $fileInfo[6];
                $params[":i7$i"] = filesize($path . $fileInfo[7]);
                $params[":i8$i"] = strtoupper(md5_file($path . $fileInfo[7], false));
                $params[":i9$i"] = $fileInfo[7];
                
                $i++;
            } else {
                $this->stdout('File not found: ' . $path . $fileInfo[7] . "\n" , Console::FG_YELLOW, Console::BOLD);
            }
        }
        $values = substr($values, 1);
        
        if (count($params) > 0)
            \Yii::$app->db->createCommand("INSERT INTO {{%download}} (sort, file_type, name, os, arch, processor, brand, size, md5, path) VALUES $values ON DUPLICATE KEY UPDATE sort = VALUES(sort), size = VALUES(size), md5 = VALUES(md5), path = VALUES(path)", $params)->execute();
    }
}
