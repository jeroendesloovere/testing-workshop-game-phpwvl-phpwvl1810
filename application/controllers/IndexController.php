<?php
/**
 * Class IndexController
 *
 * @category TheiaLive
 * @package Default
 */
class IndexController extends Zend_Controller_Action
{
    /**
     * @var Zend_Session_Namespace
     */
    protected $_session;

    /**
     * @var Zend_Log
     */
    protected $_logger;

    public function init()
    {
        $this->_session = new Zend_Session_Namespace('contact');
        $this->_logger = $this->getInvokeArg('bootstrap')->getResource('log');
    }

    public function indexAction()
    {
        // action body
    }

    public function contactAction()
    {
        $form = new Application_Form_Contact([
            'method' => 'POST',
            'action' => $this->view->url([
                'module' => 'default',
                'controller' => 'index',
                'action' => 'contact',
            ], null, true),
        ]);

        if (Zend_Auth::getInstance()->hasIdentity()) {
            $identity = Zend_Auth::getInstance()->getIdentity();
            $account = unserialize($identity);
            $form->getElement('name')->setValue($account->getFirstName() . ' ' . $account->getLastName());
            $form->getElement('email')->setValue($account->getEmail());
        }

        if ($this->getRequest()->isPost()) {

            if ($form->isValid($this->getRequest()->getPost())) {

                try {
                    $this->sendMail(
                        $form->getElement('name')->getValue(),
                        $form->getElement('email')->getValue(),
                        $form->getElement('comment')->getValue()
                    );
                } catch (Zend_Mail_Exception $exception) {
                    $this->_logger->crit('Cannot send e-mail: ' . $exception->getMessage());
                    $this->_logger->debug($exception->getTraceAsString());
                    return $this->_helper->redirector('failure', 'index', 'default');
                }

                return $this->_helper->redirector('success', 'index', 'default');
            }
        }

        $this->view->contactForm = $form;
    }

    private function sendMail($name, $email, $comment)
    {
        $this->_logger->info(sprintf('Sending out new e-mail from "%s" <%s>', $name, $email));

        $html = file_get_contents(APPLICATION_PATH . "/templates/contact.html");
        $text = file_get_contents(APPLICATION_PATH . "/templates/contact.txt");

        $html = str_replace('{{MSG}}', nl2br($comment), $html);
        $text = str_replace('{{MSG}}', $comment, $text);

        // send message
        $mail = new Zend_Mail();
        $mail->setFrom($email, $name);
        $mail->addTo('info@in2it.be');
        $mail->setSubject('Contact request from TheiaLive');
        $mail->setBodyHtml($html);
        $mail->setBodyText($text);
        $mail->send();
    }

    public function successAction()
    {
        // action body
    }

    public function failureAction()
    {
        $this->getResponse()->setHttpResponseCode(400);
    }
}
