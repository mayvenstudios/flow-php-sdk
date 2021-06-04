<?php

namespace FlowSDK;


use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Flow {
    protected $type;
    protected $file;
    protected $args;
    protected $eventName;
    protected $eventMinBlock;
    protected $eventMaxBlock;
    protected $extraParam;


    function __construct()
    {
        $this->resetParams();
    }


    public function run(){

        $cmd = [config('flow.path').'flow'];

        if($this->type == 'transaction'){
            if(!$this->file){
                return false;
            }
            $cmd[] = 'transactions';
            $cmd[] = 'send';
            $cmd[] = $this->file;
        } else if($this->type == 'script'){
            if(!$this->file){
                return false;
            }
            $cmd[] = 'scripts';
            $cmd[] = 'execute';
            $cmd[] = $this->file;
        } else if($this->type == 'event'){
            if(!$this->eventName){
                return false;
            }
            $cmd[] = 'events';
            $cmd[] = 'get';
            $cmd[] = $this->eventName;
            $cmd[] = $this->eventMinBlock;
            $cmd[] = $this->eventMaxBlock;
        } else if($this->type == 'block'){
            $cmd[] = 'blocks';
            $cmd[] = 'get';
            if(count($this->args) > 0){
                $this->args[0];
            } else {
                $cmd[] = 'latest';
            }
        }

        if($this->extraParam != '') {
            $cmd[] = $this->extraParam;
        }
        if(count($this->args) > 0 && $this->type != 'block') {
            $cmd[] = '--args-json';
            $cmd[] = json_encode($this->args);
        }

        if(config('services.flow.network') != 'emulator'){
            $cmd[] = '--network';
            $cmd[] = config('services.flow.network');
            if($this->type == 'transaction') {
                $cmd[] = '--signer';
                $cmd[] = 'testnet-account';
            }
        }
        $cmd[] = '-o';
        $cmd[] = 'json';


        $process = new Process($cmd, base_path('cadence'));
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }

    protected function resetParams(){
        $this->type = '';
        $this->file = '';
        $this->args = [];
        $this->eventName = '';
        $this->eventMinBlock = 0;
        $this->eventMaxBlock = 0;
        $this->extraParam = '';
    }

    public function transaction($file){
        $this->resetParams();
        $this->type = 'transaction';
        $this->file = $file;
        return $this;
    }

    public function script($file){
        $this->resetParams();
        $this->type = 'script';
        $this->file = $file;
        return $this;
    }
    public function event($name){
        $this->resetParams();
        $this->type = 'event';
        $this->eventName = $name;
        return $this;
    }
    public function block(){
        $this->resetParams();
        $this->type = 'block';
        return $this;
    }

    public function file($file){
        $this->file = $file;
        return $this;
    }
    public function eventName($eventName){
        $this->eventName = $eventName;
        return $this;
    }
    public function minBlock($height){
        $this->eventMinBlock = $height;
        return $this;
    }
    public function maxBlock($height){
        $this->eventMaxBlock = $height;
        return $this;
    }
    public function param($param){
        $this->extraParam = $param;
    }

    protected function arg($value){
        $this->args[] = $value;
        return $this;
    }
    protected function argGeneric($key, $value){
        $this->args[] = ['type' => $key, 'value' => $value];
        return $this;
    }
    public function argInt($value){
        return $this->argGeneric('UInt64', ''.$value);
    }
    public function argFix($value){
        return $this->argGeneric('UFix64', ''.number_format($value, 2, '.', ''));
    }
    public function argString($value){
        return $this->argGeneric('String', $value);
    }
    public function argAddress($value){
        return $this->argGeneric('Address', $value);
    }
    public function argBool($value){
        return $this->argGeneric('Bool', $value ? true : false);
    }
    public function argDictionaryString($arr){
        $mappedArr = collect($arr)->map(function($val, $key){
            return [
                'key' => [
                    'type' => 'String',
                    'value' => $key
                ],
                'value' => [
                    'type' => 'String',
                    'value' => $val
                ]
            ];
        });
        return $this->argGeneric('Dictionary', $mappedArr->values()->toArray());
    }


    public function getLatestBlock(){
        return $this->block()->run();
    }
    public function getBlock($id){
        return $this->block()
            ->argInt($id)
            ->run();
    }
}