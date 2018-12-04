<?php
require_once("vendor/autoload.php");
$controller->addAction('', false, false);
$controller->addAction('mail', false, false);


class ControllerHome
{
    public static function defaut()
    {
        $presentation = "Dévelloppeur full stack capable de réaliser vos application les plus folles seul votre imagination es une limite.";
        $input = ["subject","name","mail","content"];
        $empty = false;
        $i = 0;
        while ($i < count($input)) {
            if (empty($_POST[$input[$i]]) === true) {
                $empty = true;
            }
            $i++;
        }

        if ($empty === false) {
            $json = file_get_contents('./config.json');
            $json_data = json_decode($json, true);
            $transport = (new Swift_SmtpTransport($json_data['smtp']['url'], $json_data['smtp']['port'], $json_data['smtp']['protocol']))
            ->setUsername($json_data['smtp']['username'])
            ->setPassword($json_data['smtp']['pass'])
            ;

            // Create the Mailer using your created Transport
            $mailer = new Swift_Mailer($transport);

            // Create a message
            $message = (new Swift_Message($_POST['subject']))
            ->setFrom([$_POST['mail']])
            ->setTo(['dev@survive-in-hell.fr'])
            ->setBody($_POST['content']." par ".$_POST['name'])
            ;

            // Send the message
            $result = $mailer->send($message);
        }

        return ["header" => ["view" => "header/default.twig","title" => "Hervy Steven","subtitle" => $presentation,"img" => "/assets/img/home-bg.jpg"]];
    }

    public static function mail()
    {
        // Create the Transport
        $json = file_get_contents('./config.json');
        $json_data = json_decode($json, true);
        $transport = (new Swift_SmtpTransport($json_data['smtp']['url'], $json_data['smtp']['port'], $json_data['smtp']['protocol']))
        ->setUsername($json_data['smtp']['username'])
        ->setPassword($json_data['smtp']['pass'])
        ;

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);

        // Create a message
        $message = (new Swift_Message('sujet'))
        ->setFrom(['dev@survive-in-hell.fr'])
        ->setTo(['dev@survive-in-hell.fr'])
        ->setBody('Here is the message itself')
        ;

        // Send the message
        $result = $mailer->send($message);
    }
}
