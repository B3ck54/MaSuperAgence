<?php
namespace App\Notification;

use App\Entity\Contact;
use Twig\Environment;

class ContactNotification {

    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var Environment
     */
    private $renderer;


    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
        /**
         * @var \Swift_Mailer
         */
        $this->mailer = $mailer; //permet d'envoyer un email

        /**
         * @var Environment
         */
        $this->renderer = $renderer; //génére une vue HTML
    }

    //Gérer les emails


    public function notify(Contact $contact){
        // premiere étape est de générer un message
        $message = (new \Swift_Message('Agence : ' . $contact->getProperty()->getTitle()))
            ->setFrom('noreply@agence.fr')
            ->setTo('contact@agence.fr')
            ->setReplyTo($contact->getEmail())
            ->setBody($this->renderer->render('emails/contact.html.twig',[
                'contact'=>$contact
            ]),'text/html');

        // envoi du message
        $this->mailer->send($message);

    }

}