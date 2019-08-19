<?php

    require '../../app_ordem_servico/bibliotecas/PHPMailer/Exception.php';
    require '../../app_ordem_servico/bibliotecas/PHPMailer/OAuth.php';
    require '../../app_ordem_servico/bibliotecas/PHPMailer/PHPMailer.php';
    require '../../app_ordem_servico/bibliotecas/PHPMailer/POP3.php';
    require '../../app_ordem_servico/bibliotecas/PHPMailer/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    class Mensagem
    {
        private $usuario_email = array('usuario' => '', 'senha' => 'all0211a');

        private $assunto = 'Mensagem Teste';
        private $mensagem = 'Teste de mensagem !';

        private $prestador_os;
        private $usuario_os;

        public $status = array('codigo_status' => null,'descricao_status' => null);

        public function __construct(Prestador $prestador, Usuario $usuario)
        {
            $this->prestador_os = $prestador;
            $this->usuario_os = $usuario;
        }

        public function __get($atributo)
        {
            return $this->$atributo;
        }

        public function __set($atributo,$valor)
        {
            $this->$atributo = $valor;
        }

        public function enviarEmail()
        {
            $mail = new PHPMailer(true);

            $this->usuario_email['usuario'] = $this->usuario_os->__get('email');

            try 
            {
                $mail->SMTPDebug = 1;                                       // Enable verbose debug output
                $mail->isSMTP();                                            // Set mailer to use SMTP
                $mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'allangts@gmail.com';                     // SMTP username
                $mail->Password   = 'mafiaa.,';                               // SMTP password
                $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
                $mail->Port       = 587;                                    // TCP port to connect to

                //Recipients
                $mail->setFrom('allangts@gmail.com', '[San Michel] - Ordem de Serviço');
                $mail->addAddress($this->prestador_os->__get('email'));     // Add a recipient
                //$mail->addAddress('ellen@example.com');               // Name is optional
                //$mail->addReplyTo('info@example.com', 'Information');
                //$mail->addCC('cc@example.com');
                //$mail->addBCC('bcc@example.com');

                // Attachments :: anexos
                //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = $this->assunto;
                $mail->Body    = $this->mensagem;
                $mail->AltBody = 'É necessario utilizar um cliente que suporte HTML para ter acesso total ao conteudo desta mensagem !';

                $mail->send();

                $this->status['codigo_status'] = 1;
                $this->status['descricao_status'] = 'Mensagem enviada com sucesso !';
            } 
            catch (Exception $e) 
            {
                $this->status['codigo_status'] = 2;
                $this->status['descricao_status'] = "Não foi possivel enviar o email. Detalhes do Error: {$e->ErrorInfo}";
            }
        }
    }
?>