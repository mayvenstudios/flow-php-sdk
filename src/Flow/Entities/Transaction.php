<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: flow/entities/transaction.proto

namespace Flow\Entities;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>flow.entities.Transaction</code>
 */
class Transaction extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>bytes script = 1;</code>
     */
    protected $script = '';
    /**
     * Generated from protobuf field <code>repeated bytes arguments = 2;</code>
     */
    private $arguments;
    /**
     * Generated from protobuf field <code>bytes reference_block_id = 3;</code>
     */
    protected $reference_block_id = '';
    /**
     * Generated from protobuf field <code>uint64 gas_limit = 4;</code>
     */
    protected $gas_limit = 0;
    /**
     * Generated from protobuf field <code>.flow.entities.Transaction.ProposalKey proposal_key = 5;</code>
     */
    protected $proposal_key = null;
    /**
     * Generated from protobuf field <code>bytes payer = 6;</code>
     */
    protected $payer = '';
    /**
     * Generated from protobuf field <code>repeated bytes authorizers = 7;</code>
     */
    private $authorizers;
    /**
     * Generated from protobuf field <code>repeated .flow.entities.Transaction.Signature payload_signatures = 8;</code>
     */
    private $payload_signatures;
    /**
     * Generated from protobuf field <code>repeated .flow.entities.Transaction.Signature envelope_signatures = 9;</code>
     */
    private $envelope_signatures;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $script
     *     @type string[]|\Google\Protobuf\Internal\RepeatedField $arguments
     *     @type string $reference_block_id
     *     @type int|string $gas_limit
     *     @type \Flow\Entities\Transaction\ProposalKey $proposal_key
     *     @type string $payer
     *     @type string[]|\Google\Protobuf\Internal\RepeatedField $authorizers
     *     @type \Flow\Entities\Transaction\Signature[]|\Google\Protobuf\Internal\RepeatedField $payload_signatures
     *     @type \Flow\Entities\Transaction\Signature[]|\Google\Protobuf\Internal\RepeatedField $envelope_signatures
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Flow\Entities\Transaction::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>bytes script = 1;</code>
     * @return string
     */
    public function getScript()
    {
        return $this->script;
    }

    /**
     * Generated from protobuf field <code>bytes script = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setScript($var)
    {
        GPBUtil::checkString($var, False);
        $this->script = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated bytes arguments = 2;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Generated from protobuf field <code>repeated bytes arguments = 2;</code>
     * @param string[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setArguments($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::BYTES);
        $this->arguments = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>bytes reference_block_id = 3;</code>
     * @return string
     */
    public function getReferenceBlockId()
    {
        return $this->reference_block_id;
    }

    /**
     * Generated from protobuf field <code>bytes reference_block_id = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setReferenceBlockId($var)
    {
        GPBUtil::checkString($var, False);
        $this->reference_block_id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>uint64 gas_limit = 4;</code>
     * @return int|string
     */
    public function getGasLimit()
    {
        return $this->gas_limit;
    }

    /**
     * Generated from protobuf field <code>uint64 gas_limit = 4;</code>
     * @param int|string $var
     * @return $this
     */
    public function setGasLimit($var)
    {
        GPBUtil::checkUint64($var);
        $this->gas_limit = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>.flow.entities.Transaction.ProposalKey proposal_key = 5;</code>
     * @return \Flow\Entities\Transaction\ProposalKey
     */
    public function getProposalKey()
    {
        return isset($this->proposal_key) ? $this->proposal_key : null;
    }

    public function hasProposalKey()
    {
        return isset($this->proposal_key);
    }

    public function clearProposalKey()
    {
        unset($this->proposal_key);
    }

    /**
     * Generated from protobuf field <code>.flow.entities.Transaction.ProposalKey proposal_key = 5;</code>
     * @param \Flow\Entities\Transaction\ProposalKey $var
     * @return $this
     */
    public function setProposalKey($var)
    {
        GPBUtil::checkMessage($var, \Flow\Entities\Transaction\ProposalKey::class);
        $this->proposal_key = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>bytes payer = 6;</code>
     * @return string
     */
    public function getPayer()
    {
        return $this->payer;
    }

    /**
     * Generated from protobuf field <code>bytes payer = 6;</code>
     * @param string $var
     * @return $this
     */
    public function setPayer($var)
    {
        GPBUtil::checkString($var, False);
        $this->payer = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated bytes authorizers = 7;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getAuthorizers()
    {
        return $this->authorizers;
    }

    /**
     * Generated from protobuf field <code>repeated bytes authorizers = 7;</code>
     * @param string[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setAuthorizers($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::BYTES);
        $this->authorizers = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated .flow.entities.Transaction.Signature payload_signatures = 8;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getPayloadSignatures()
    {
        return $this->payload_signatures;
    }

    /**
     * Generated from protobuf field <code>repeated .flow.entities.Transaction.Signature payload_signatures = 8;</code>
     * @param \Flow\Entities\Transaction\Signature[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setPayloadSignatures($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Flow\Entities\Transaction\Signature::class);
        $this->payload_signatures = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated .flow.entities.Transaction.Signature envelope_signatures = 9;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getEnvelopeSignatures()
    {
        return $this->envelope_signatures;
    }

    /**
     * Generated from protobuf field <code>repeated .flow.entities.Transaction.Signature envelope_signatures = 9;</code>
     * @param \Flow\Entities\Transaction\Signature[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setEnvelopeSignatures($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Flow\Entities\Transaction\Signature::class);
        $this->envelope_signatures = $arr;

        return $this;
    }

}

