<?php

    use FlowSDK\Flow;

    require '../../vendor/autoload.php';

    $flow = new Flow();

    print_r($flow->ping());