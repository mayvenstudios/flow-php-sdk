<?php
namespace Flow\Access;
use Elliptic\EC;

require '../vendor/autoload.php';

function numeric_encode(string $input)
    {
        if (!$input || $input < 0) {
            return '';
        }
        $intInput = strval($input);
        $output = dechex($intInput);
        $outputLen = mb_strlen($output);
        if ($outputLen > 0 && $outputLen % 2 !== 0) {
            return '0' . $output;
        }
        return $output;
    }

function str_encode(string $input)
    {
        
        $output = bin2hex($input);
        $outputLen = mb_strlen($output);
        if ($outputLen > 0 && $outputLen % 2 !== 0) {
            $output= '0' . $output;
        }
        return $output;
    }

function encodeInput($input)
{
    if (is_string($input)) {
        return str_encode($input);
    } elseif (is_numeric($input)) {
        return numeric_encode($input);
    } elseif ($input === null) {
        return '';
    }
    throw new InvalidArgumentException('The input type didn\'t support.');
}

function encode($inputs)
{
    $output = '';
    if (is_array($inputs)) {
        foreach ($inputs as $input) {
            $output .= encode($input);
        }
        $length = mb_strlen($output) / 2;
        return encodeLength($length, 192) . $output;
    }
    $input = encodeInput($inputs);
    $length = mb_strlen($input) / 2;

    // first byte < 0x80
    if ($length === 1 && mb_substr($input, 0, 1) < 8) {
        return $input;
    }
    return encodeLength($length, 128) . $input;
}

function intToHex(int $input)
{
        $hex = dechex($input);
        return padToEven($hex);
}

function padToEven(string $input)
{
    if ((strlen($input) % 2) !== 0 ) {
        $input = '0' . $input;
    }
    return $input;
}

function encodeLength(int $length, int $offset)
{
    if ($length < 56) {
        return dechex(strval($length + $offset));
    }
    $hexLength = intToHex($length);
    $firstByte = intToHex($offset + 55 + (strlen($hexLength) / 2));
    return $firstByte . $hexLength;
}

class FlowClient extends \Grpc\BaseStub{

    public function obj2dic($obj){
        
        $iterators  = array("CollectionGuarantees","BlockSeals","Signatures","Contracts","Keys","Results","Events");
        $binary = array("ExecutionReceiptSignatures","Signatures","ResultApprovalSignatures");
        $identifiers = array("TransactionId","PublicKey","Address", "ParentId","Id","CollectionId","BlockId","ExecutionReceiptId");     

        $class = new \ReflectionObject($obj);
        $methods = $class->getMethods();
        $result = array();
    
        foreach($methods as $method){
            if (strpos($method, "get")!=0){
                $reflectionMethod = $class->getMethod($method->name);
                $name = substr($method->name, 3);
                
                $value = $reflectionMethod->invoke($obj);

                if (in_array($name, $binary)){
                    $bytes = "";
                    foreach ($value as $v){
                        $bytes .= $v;
                    }
                    $value = bin2hex($bytes);
                }
                
                if (is_object($value)){
                    if (in_array($name, $iterators))
                    {
                        $inner = array();
                        foreach ($value as $k => $v) {
                            if (is_object($v)){
                                $inner[$k] =  $this->obj2dic($v);
                            }
                            else{
                                $inner[$k]=$v;
                            }
                        }
                        $value =$inner;
                    }
                    else{
                        $value = $this->obj2dic($value);
                    }
                }
                
                if (is_string($value)){                    
                    if (in_array($name, $identifiers)){
                        $value = bin2hex($value);
                    }
                }
    
                $result[$name] = $value;
    
            }        
        }
        return $result;
    }

    
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
            
  
    }

    public function process(\Google\Protobuf\Internal\Message $argument, $requestEndpoint, $expectedResponse, $metadata=[],$options=[]){
        
        $response =  $this->_simpleRequest("/flow.access.AccessAPI/$requestEndpoint",
            $argument,
            ['\\Flow\Access\\' . $expectedResponse, 'decode'],
            $metadata, $options)->wait();

        $status = $response[1];
        if ($status->code!=0)
        {
            throw new \Exception("Error: $status->code Details: $status->details");
        }
        return $response[0];
    }

    public function ping(){
        $message = new PingRequest();
        $response =  $this->process($message, "Ping", "PingResponse");
        return $this->obj2dic($response);
    }

    public function getLatestBlockHeader(){
        $message = new GetLatestBlockHeaderRequest();
        $response =  $this->process($message, "GetLatestBlockHeader", "BlockHeaderResponse");
        return $this->obj2dic($response->getBlock());
    }

    public function getBlockHeaderByID($id="LATEST"){
        if ($id=="LATEST"){
            return getLatestBlockHeader();
        }
        $message = new GetBlockHeaderByIDRequest();
        $message->setId(hex2bin(str_pad($id, 64, "0", STR_PAD_LEFT)));
        $response =  $this->process($message, "GetBlockHeaderByID", "BlockHeaderResponse");
        return $this->obj2dic($response->getBlock());
    }

    public function getBlockHeaderByHeight($height="LATEST"){
        if ($height=="LATEST"){
            return getLatestBlockHeader();
        }
        $message = new GetBlockHeaderByHeightRequest();
        $message->setHeight($height);
        $response =  $this->process($message, "GetBlockHeaderByHeight", "BlockHeaderResponse");
        return $this->obj2dic($response->getBlock());
    }

    public function getLatestBlock($is_sealed=TRUE){
        $message = new GetLatestBlockRequest();
        $message->setIsSealed($is_sealed);
        $response =  $this->process($message, "GetLatestBlock", "BlockResponse");
        return $this->obj2dic($response->getBlock());
    }

    public function getBlockByID($id="LATEST"){
        if ($id=="LATEST"){
            return getLatestBlock();
        }
        $message = new GetBlockByIDRequest();
        $message->setId(hex2bin(str_pad($id, 64, "0", STR_PAD_LEFT)));
        $response =  $this->process($message, "GetBlockByID", "BlockResponse");
        return $this->obj2dic($response->getBlock());
    }

    public function getBlockByHeight($height="LATEST"){
        if ($height=="LATEST"){
            return getLatestBlock();
        }
        $message = new GetBlockByHeightRequest();
        $message->setHeight($height);
        $response =  $this->process($message, "GetBlockByHeight", "BlockResponse");
        return $this->obj2dic($response->getBlock());
    }

    public function getCollectionByID($id){
        $message = new GetCollectionByIDRequest();
        $message->setId(hex2bin(str_pad($id, 64, "0", STR_PAD_LEFT)));
        $response =  $this->process($message, "GetCollectionByID", "CollectionResponse");
        return $this->obj2dic($response->GetCollection());
    }

    public function getTransaction($id){
        $message = new GetTransactionRequest();
        $message->setId(hex2bin(str_pad($id, 64, "0", STR_PAD_LEFT)));
        $response =  $this->process($message, "GetTransaction", "TransactionResponse");
        return $this->obj2dic($response->GetTransaction());
    }
    
    public function getTransactionResult($id){
        $message = new GetTransactionResultRequest();
        $message->setId(hex2bin(str_pad($id, 64, "0", STR_PAD_LEFT)));
        $response =  $this->process($message, "GetTransactionResult", "TransactionResultResponse");
        return $this->obj2dic($response);
    }

    public function getAccount($address){
        $message = new GetAccountRequest();
        $message->setAddress(hex2bin(str_pad($address, 16, "0", STR_PAD_LEFT)));
        $response =  $this->process($message, "GetAccount", "GetAccountResponse");
        return $this->obj2dic($response->getAccount());
    }

    public function getAccountAtLatestBlock($address){
        $message = new GetAccountAtLatestBlockRequest();
        $message->setAddress(hex2bin(str_pad($address, 16, "0", STR_PAD_LEFT)));
        $response =  $this->process($message, "GetAccountAtLatestBlock", "GetAccountResponse");
        return $this->obj2dic($response->getAccount());
    }

    public function getAccountAtBlockHeight($address, $block_height="LATEST"){
        if ($block_height=="LATEST"){
            return getAccountAtLatestBlock($address);
        }
        $message = new GetAccountAtBlockHeightRequest();
        $message->setAddress(hex2bin(str_pad($address, 16, "0", STR_PAD_LEFT)));
        $message->setBlockHeight($block_height);
        $response =  $this->process($message, "GetAccountAtBlockHeight", "GetAccountResponse");
        return $this->obj2dic($response->getAccount());
    }

    public function executeScriptAtLatestBlock($script){
        $message = new ExecuteScriptAtLatestBlockRequest();
        $message->setScript($script);
        $response =  $this->process($message, "ExecuteScriptAtLatestBlock", "ExecuteScriptResponse");
        return $this->obj2dic($response);
    }
    public function executeScriptAtBlockID($script, $block_id="LATEST"){
        if ($block_id=="LATEST"){
            return executeScriptAtLatestBlock($script);
        }
        $message = new ExecuteScriptAtBlockIDRequest();
        $message->setScript($script);
        $message->setBlockId($block_id);
        $response =  $this->process($message, "ExecuteScriptAtBlockID", "ExecuteScriptResponse");
        return $this->obj2dic($response);
    }

    public function executeScriptAtBlockHeight($script, $block_height="LATEST"){
        if ($block_height=="LATEST"){
            return executeScriptAtLatestBlock($script);
        }
        $message = new ExecuteScriptAtBlockHeightRequest();
        $message->setScript($script);
        $message->setBlockHeight($block_height);
        $response =  $this->process($message, "ExecuteScriptAtBlockHeight", "ExecuteScriptResponse");
        return $this->obj2dic($response);
    }

    public function getEventsForHeightRange($type, $start_height, $end_height){
        $message = new GetEventsForHeightRangeRequest();
        $message->setType($type);
        $message->setStartHeight($start_height);
        $message->setEndHeight($end_height);
        $response =  $this->process($message, "GetEventsForHeightRange", "EventsResponse");
        return $this->obj2dic($response["results"]);
    }

    public function getEventsForBlockIDs($type, $block_ids){
        $message = new GetEventsForBlockIDsRequest();
        $message->setType($type);
        $blocks = array();
        foreach($block_ids as $b){
            $blocks[]=hex2bin(str_pad($b, 64, "0", STR_PAD_LEFT));
        }
        $message->setBlockIds($blocks);
        $response =  $this->process($message, "GetEventsForBlockIDs", "EventsResponse");
        return $this->obj2dic($response)["Results"];
    }
    
    public function getNetworkParameters(){
        $message = new GetNetworkParametersRequest();
        $response =  $this->process($message, "GetNetworkParameters", "GetNetworkParametersResponse");
        return $this->obj2dic($response)["Results"];
    }

    public function getLatestProtocolStateSnapshot(){
        $message = new GetLatestProtocolStateSnapshotRequest();
        $response =  $this->process($message, "GetLatestProtocolStateSnapshot", "ProtocolStateSnapshotResponse");
        return $this->obj2dic($response);
    }

    private function getPayload($transaction){
        
        $baseAuthorizers = $transaction->getAuthorizers();
        $authorizers = array();
        foreach($baseAuthorizers as $auth){
            $authorizers[]=$auth;
        }

        $baseArguments = $transaction->getArguments();
        $arguments = array();
        foreach($baseArguments as $arg){
            $arguments[]=$arg;
        }


        $payload =  [
            $transaction->getScript(),
            $arguments,
            $transaction->getReferenceBlockId(),
            $transaction->getGasLimit(),
            $transaction->getProposalKey()->getAddress(),
            $transaction->getProposalKey()->getKeyId(),
            $transaction->getProposalKey()->getSequenceNumber(),
            $transaction->getPayer(),
            $authorizers
          ];  
      
        //$rlp = new RLP;
        //$encodedBuffer = $rlp->encode($payload);
        return $payload;
    }
    private function getEnvelope($transaction, $payloadSignatures){
        $envelope = array();
        $envelope[] = $this->getPayload($transaction);
        $envelope[] = $payloadSignatures;
        return $envelope;
    }

    private function signData($data, $signerKey, $tag, $payloadSignatures=NULL){
        $ec = new EC($signerKey["type"]);

        $key = $ec->keyFromPrivate($signerKey["key"]);
    
        $signature = $key->sign(
            hash("sha3-256", $tag . $data)
        );
        
        $signature = ($signature->r->toString(16, 32) . $signature->s->toString(16, 32));
      

        return hex2bin($signature);
    }

    public function sendTransaction($proposer, $code, $args=[], $keys=[], $payer=NULL, $authorizers=[], $gasLimit=1000){
        
        if ($payer==NULL){
            $payer = $proposer;
        }

        if (count($authorizers)==0){
            $authorizers[] = $proposer;
        }

        $account = $this->getAccount($proposer);
        $key = $account["Keys"][$keys[$proposer]["keyId"]];

        $proposalKey = new \Flow\Entities\Transaction\ProposalKey();
        $proposalKey->setAddress(str_pad(hex2bin($proposer), 8, "\x00",STR_PAD_LEFT));
        $proposalKey->setSequenceNumber($key["SequenceNumber"]);
        $proposalKey->setKeyId($key["Index"]);
        
        $transaction = new \Flow\Entities\Transaction();
        $transaction->setProposalKey($proposalKey);

        $latest = $this->getLatestBlock();
        $reference_block_id =str_pad(hex2bin($latest['Id']), 16, "\x00",STR_PAD_LEFT);
        $transaction->setReferenceBlockId($reference_block_id);

        $transaction->setScript($code);
        $transaction->setArguments($args);
        $transaction->setGasLimit($gasLimit);

        $transaction->setPayer(str_pad(hex2bin($payer), 8, "\x00",STR_PAD_LEFT));
        
        $authbinary = array();
        foreach($authorizers as $auth){
            $authbinary[] = str_pad(hex2bin($auth), 8, "\x00",STR_PAD_LEFT);
        }
        $transaction->setAuthorizers($authbinary);

        $payload = $this->getPayload($transaction);
        $payload = encode($payload);
       
        
        $payloadSignatures = array();
        $payloadSignaturesCanonical = array();
        $payloadSigners = array();

        if ($proposer!=$payer){
            $rawsignature = $this->signData(hex2bin($payload), $keys[$proposer], str_pad("FLOW-V0.0-transaction", 32, "\x00", STR_PAD_RIGHT));
            if ($rawsignature) {
                $signature = new \Flow\Entities\Transaction\Signature();
                $signature->setAddress(hex2bin(str_pad($proposer, 16, "0", STR_PAD_LEFT)));
                $signature->setKeyId($keys[$proposer]["keyId"]);
                $signature->setSignature($rawsignature);
                $payloadSignatures[] = $signature;
                $payloadSigners[]=$proposer;
                $payloadSignaturesCanonical[]= [
                    count($payloadSignaturesCanonical), 
                    $keys[$proposer]["keyId"], 
                    $rawsignature
                ];
            }
        }
        
        foreach($authorizers as $auth){
            if ($proposer==$auth) continue;
            if (in_array($auth, $payloadSigners)) continue;
            $rawsignature = $this->signData(hex2bin($payload), $keys[$auth], str_pad("FLOW-V0.0-transaction", 32, "\x00", STR_PAD_RIGHT));
            if ($rawsignature) {
                $signature = new \Flow\Entities\Transaction\Signature();
                $signature->setAddress(hex2bin(str_pad($auth, 16, "0", STR_PAD_LEFT)));
                $signature->setKeyId($keys[$auth]["keyId"]);
                $signature->setSignature($rawsignature);
                $payloadSignatures[] = $signature;
                $payloadSignaturesCanonical[]= [
                    count($payloadSignaturesCanonical), 
                    $keys[$proposer]["keyId"], 
                    $rawsignature
                ];
            }
        }

        $transaction->setPayloadSignatures($payloadSignatures);
        $envelope = encode($this->getEnvelope($transaction, $payloadSignaturesCanonical));
        
        //sign envelope with payer
        $rawsignature = $this->signData(hex2bin($envelope), $keys[$payer], str_pad("FLOW-V0.0-transaction", 32, "\x00", STR_PAD_RIGHT));
        if ($rawsignature) {
            $signature = new \Flow\Entities\Transaction\Signature();
            $signature->setAddress(str_pad(hex2bin($payer), 8, "\x00",STR_PAD_LEFT));
            $signature->setKeyId($keys[$payer]["keyId"]);
            $signature->setSignature($rawsignature);
            $transaction->setEnvelopeSignatures([$signature]);
        }

       
        $message = new SendTransactionRequest();
        $message->setTransaction($transaction);
        $response =  $this->process($message, "SendTransaction", "SendTransactionResponse");
        return $this->obj2dic($response);
    }


}

function test_transaction_signing(){

    $client = new FlowClient('localhost:3569', [
        'credentials' => \Grpc\ChannelCredentials::createInsecure(),
    ]);

    try{
        $code = 'transaction { 
            prepare(acct: AuthAccount) {}
        
            execute {log("hello")}
        }
        ';
        
        $KEYS = [
            "f8d6e0586b0a20c7"=> [
                "keyId" =>  0, 
                "key"   =>  "57f1d8c508e147529b89192a858fdaf62a9f27e698ad5b4a1947494bc062b836",
                "type"  =>  "p256" 
                ]
            ];

        print_r(
            $client->sendTransaction("f8d6e0586b0a20c7", $code=$code, [], $keys=$KEYS)
        );

    }
    catch (\Exception $e) {
        print_r($e->getMessage());
    }

}

//print_r($client->getLatestBlockHeader());
//print_r($client->getBlockHeaderByHeight(0));
//print_r($client->getBlockHeaderByID("7bc42fe85d32ca513769a74f97f7e1a7bad6c9407f0d934c2aa645ef9cf613c7"));

//print_r($client->getLatestBlock());
//print_r($client->getBlockByHeight(15509598));
//print_r($client->getBlockByID("7a37e8c2a6295887acb35478f85d0ef201ee707feea5012fc0ff773438d647d1"));

//print_r($client->getAccount("0b2a3299cc857e29"));
//print_r($client->getAccountAtLatestBlock("0b2a3299cc857e29"));
//print_r($client->getAccountAtBlockHeight("0b2a3299cc857e29",0));

//print_r($client->executeScriptAtLatestBlock("pub fun main(): Int {return 1}"));
//print_r($client->executeScriptAtBlockHeight("pub fun main(): Int {return 1}",0));
//print_r($client->executeScriptAtBlockID("pub fun main(): Int {return 1}","7bc42fe85d32ca513769a74f97f7e1a7bad6c9407f0d934c2aa645ef9cf613c7"));
//print_r($client->getNetworkParameters());
//print_r($client->getLatestProtocolStateSnapshot());

//print_r($client->getEventsForBlockIDs("A.0b2a3299cc857e29.TopShot.Withdraw", ["7fd240c558e13986013be111cfd05a7c6938405cb5b84c2bb8f4d501dcea3bab", "45c9126536c86096ee4adf0bc18280a05f53250377c075010eaca98e645cc536"]));

       




