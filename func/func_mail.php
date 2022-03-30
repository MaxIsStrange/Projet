<?php

class Mail
{
    
    private string $subject;
    private string $headers = "From: StageTracker <stagetracker@hsbay.space>";
    private string $message;




    public function setMail($type)
    {
        switch ($type) {
            case 'modif':
                $this->message = "Bonjour,\nVotre compte StageTracker vient d'être modifié. \nSi ce n'est pas votre action, veuillez modifier tout de suite votre mot de passe et mail.\n\nMerci de nous faire confiance,\nToute l'équipe StageTracker.";
                $this->subject = "Modification de vos informations - StageTracker";
                break;

            case 'inscri':
                $this->message = "Bonjour,\nVotre compte StageTracker à bien été crée !\nNous vous souhaitons la bienvenue sur StageTracker et espérons que vous trouverez vite un stage parmi les nombreux proposés.\n\nMerci de nous faire confiance,\nToute l'équipe StageTracker.";
                $this->subject = "Inscription réussie - StageTracker";
                break;

            default:
                $this->message = "Bonjour,\nCe message est surement une erreur.\n\nMerci de nous faire confiance,\nToute l'équipe StageTracker.";
                $this->subject = "StageTracker";
                break;
        }
    }

    public function sendMail($to)
    {
        mail($to, $this->subject, $this->message, $this->headers);
    }
}

$mailer = new Mail;
