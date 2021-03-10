<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: flow/access/access.proto

namespace Flow\Access;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>flow.access.BlockResponse</code>
 */
class BlockResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>.flow.entities.Block block = 1;</code>
     */
    protected $block = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Flow\Entities\Block $block
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Flow\Access\Access::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>.flow.entities.Block block = 1;</code>
     * @return \Flow\Entities\Block
     */
    public function getBlock()
    {
        return isset($this->block) ? $this->block : null;
    }

    public function hasBlock()
    {
        return isset($this->block);
    }

    public function clearBlock()
    {
        unset($this->block);
    }

    /**
     * Generated from protobuf field <code>.flow.entities.Block block = 1;</code>
     * @param \Flow\Entities\Block $var
     * @return $this
     */
    public function setBlock($var)
    {
        GPBUtil::checkMessage($var, \Flow\Entities\Block::class);
        $this->block = $var;

        return $this;
    }

}

