<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: flow/access/access.proto

namespace Flow\Access;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>flow.access.ExecuteScriptAtLatestBlockRequest</code>
 */
class ExecuteScriptAtLatestBlockRequest extends \Google\Protobuf\Internal\Message
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
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $script
     *     @type string[]|\Google\Protobuf\Internal\RepeatedField $arguments
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Flow\Access\Access::initOnce();
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

}

