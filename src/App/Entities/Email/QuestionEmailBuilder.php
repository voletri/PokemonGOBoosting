<?php

namespace App\Entities\Email;

use Swift_Message;

/**
 * Class QuestionEmailBuilder
 * @package App\Entities\Email
 */
class QuestionEmailBuilder implements IEmailBuilder {
    /**
     * @var Swift_Message $email
     */
    private $email;

    /**
     * QuestionEmailBuilder constructor.
     */
    public function __construct() {
        $this->email = Swift_Message::newInstance();
    }

    /**
     * @param string $title Title of email
     */
    public function buildTitle($title) {
        $this->email->setSubject($title);
    }

    /**
     * @param array|null $replayTo Associative array of email's replay to receivers
     */
    public function buildReplayTo($replayTo = null) {
        $this->email->setReplyTo($replayTo);
    }

    /**
     * @param array $from Associative array of email's senders
     */
    public function buildFrom($from) {
        $this->email->setFrom($from);
    }

    /**
     * @param array $to
     */
    public function buildTo($to) {
        $this->email->setTo($to);
    }

    /**
     * @param array|null $params Associative array of values that can be replaced in template
     */
    public function buildBody($params = null) {
        $template = file_get_contents('../assets/emailTemplates/questionEmailTemplate.html');
        if (!$params == null) {
            $template = str_replace(array_keys($params), array_values($params), $template);
        }
        $this->email->addPart($template, 'text/html');
    }

    /**
     * @return Swift_Message
     */
    public function getEMail() {
        return $this->email;
    }
}