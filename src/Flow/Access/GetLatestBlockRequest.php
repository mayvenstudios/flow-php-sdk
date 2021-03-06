<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: flow/access/access.proto

namespace Flow\Access;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>flow.access.GetLatestBlockRequest</code>
 */
class GetLatestBlockRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>bool is_sealed = 1;</code>
     */
    protected $is_sealed = false;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type bool $is_sealed
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Flow\Access\Access::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>bool is_sealed = 1;</code>
     * @return bool
     */
    public function getIsSealed()
    {
        return $this->is_sealed;
    }

    /**
     * Generated from protobuf field <code>bool is_sealed = 1;</code>
     * @param bool $var
     * @return $this
     */
    public function setIsSealed($var)
    {
        GPBUtil::checkBool($var);
        $this->is_sealed = $var;

        return $this;
    }

}

