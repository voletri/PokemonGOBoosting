<?php

namespace App\Entities\Email;

/**
 * Class EmailDirector
 * @package App\Entities\Email
 */
class EmailDirector {
    /**
     * @var IEmailBuilder $emailBuilder
     */
    private $emailBuilder;

    /**
     * EmailDirector constructor.
     * @param IEmailBuilder $emailBuilder
     */
    private function __construct(IEmailBuilder $emailBuilder) {
        $this->emailBuilder = $emailBuilder;
    }

    /**
     * @param IEmailBuilder $emailBuilder
     * @return EmailDirector
     */
    public static function newInstance(IEmailBuilder $emailBuilder) {
        return new self($emailBuilder);
    }

    /**
     * @param string $title Title of email
     * @param array $from Associative array of email's senders
     * @param array $to Associative array of email's receivers
     * @param array|null $params Associative array of values that can be replaced in template
     * @param array|null $replayTo Associative array of email's replay to receivers
     * @return \Swift_Message
     */
    public function createEmail($title, $from, $to, $params = null, $replayTo = null) {
        $this->emailBuilder->buildBody($params);
        $this->emailBuilder->buildTitle($title);
        $this->emailBuilder->buildReplayTo($replayTo);
        $this->emailBuilder->buildFrom($from);
        $this->emailBuilder->buildTo($to);
        return $this->emailBuilder->getEMail();
    }
}