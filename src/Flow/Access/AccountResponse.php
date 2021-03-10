<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: flow/access/access.proto

namespace Flow\Access;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>flow.access.AccountResponse</code>
 */
class AccountResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>.flow.entities.Account account = 1;</code>
     */
    protected $account = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Flow\Entities\Account $account
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Flow\Access\Access::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>.flow.entities.Account account = 1;</code>
     * @return \Flow\Entities\Account
     */
    public function getAccount()
    {
        return isset($this->account) ? $this->account : null;
    }

    public function hasAccount()
    {
        return isset($this->account);
    }

    public function clearAccount()
    {
        unset($this->account);
    }

    /**
     * Generated from protobuf field <code>.flow.entities.Account account = 1;</code>
     * @param \Flow\Entities\Account $var
     * @return $this
     */
    public function setAccount($var)
    {
        GPBUtil::checkMessage($var, \Flow\Entities\Account::class);
        $this->account = $var;

        return $this;
    }

}

