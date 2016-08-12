<?php

namespace App\Entities\Email;

/**
 * Interface IEmailBuilder
 * @package App\Entities\Email
 */
interface IEmailBuilder {
    /**
     * @param string $title Title of email
     */
    public function buildTitle($title);

    /**
     * @param array|null $replayTo Associative array of email's replay to receivers
     */
    public function buildReplayTo($replayTo = null);

    /**
     * @param array $from Associative array of email's senders
     */
    public function buildFrom($from);

    /**
     * @param array $to Associative array of email's receivers
     */
    public function buildTo($to);

    /**
     * @param array|null $params Associative array of values that can be replaced in template
     */
    public function buildBody($params = null);

    /**
     * @return \Swift_Message
     */
    public function getEMail();
}