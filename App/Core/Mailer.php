<?php
namespace App\Core;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer extends PHPMailer {
    public function mailServerSetup() {
        $this->SMTPDebug = SMTP::DEBUG_OFF; // off per treure tot el text a login despres
        $this->isSMTP();
        $this->Host       = 'smtp.gmail.com';
        $this->SMTPAuth   = true;
        $this->Username   = 'yaroslav.mieshcheriakov@cirvianum.cat';
        $this->Password   = 'weot pjzo rbmj bear';
        $this->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->Port       = 465;
        $this->CharSet = 'UTF-8';
    }

    public function addRec($address) {
        $this->setFrom('mailer.yaroslav.mieshcheriakov@cirvianum.cat', 'Pear Store');
        $this->addAddress($address);
        $this->addReplyTo('mailer.yaroslav.mieshcheriakov@cirvianum.cat', 'Pear Store');
    }

    public function addContent($user) {
        $this->isHTML(true);
        $this->Subject = 'Email Verification - Pear Store';
        $content = "
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; color: #333; line-height: 1.6; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #5686FE; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
                .content { background: #f9f9f9; padding: 20px; border-radius: 0 0 8px 8px; }
                .button { display: inline-block; padding: 12px 24px; background-color: #5686FE; color: white; text-decoration: none; border-radius: 5px; margin: 15px 0; }
                .footer { text-align: center; margin-top: 20px; color: #666; font-size: 0.9em; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Pear Store</h1>
                    <h2>Email Verification</h2>
                </div>
                <div class='content'>
                    <p>Hi <strong>".$user['username']."</strong>,</p>
                    <p>Welcome to Pear Store! Please verify your email address to complete your registration.</p>
                    <p>Click the button below to verify your email:</p>
                    <div style='text-align: center;'>
                        <a href='http://localhost:8085/user/verify/".$user['id']."/".$user['token']."' class='button'>Verify Email</a>
                    </div>
                    <p>If the button doesn't work, copy and paste this link in your browser:</p>
                    <p>http://localhost:8085/user/verify/".$user['id']."/".$user['token']."</p>
                    <div class='footer'>
                        <p>If you didn't create an account, please ignore this email.</p>
                        <p>Pear Store Team</p>
                    </div>
                </div>
            </div>
        </body>
        </html>";
        
        $this->Body = $content;
        $this->AltBody = "Hi ".$user['username'].", Please verify your email by visiting: http://localhost:8085/user/verify/".$user['id']."/".$user['token'];
    }

    public function addOrderContent($user, $products, $total) {
        $html = "
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
                .container { background: white; padding: 20px; border-radius: 5px; max-width: 600px; margin: 0 auto; }
                .header { background: #007bff; color: white; padding: 15px; text-align: center; border-radius: 5px 5px 0 0; }
                .product { border-bottom: 1px solid #eee; padding: 10px 0; }
                .total { font-weight: bold; font-size: 18px; margin-top: 15px; }
                .footer { margin-top: 20px; text-align: center; color: #666; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Order Confirmation</h1>
                </div>
                <p>Thank you for your order, " . $user['username'] . "!</p>
                <h3>Order Details:</h3>";
        
        foreach ($products as $product) {
            $html .= "
                <div class='product'>
                    <strong>" . $product['name'] . "</strong><br>
                    Quantity: " . $product['qty'] . "<br>
                    Price: €" . number_format($product['price'], 2) . "
                </div>";
        }
        
        $html .= "
                <div class='total'>Total: €" . number_format($total, 2) . "</div>
                <div class='footer'>
                    <p>Thank you for shopping with us!</p>
                </div>
            </div>
        </body>
        </html>";
        
        $this->Subject = 'Your Order Confirmation';
        $this->Body = $html;
        $this->isHTML(true);
    }

    public function send() {
        try {
            $result = parent::send();
            if ($result) {
                error_log("Email sent successfully to: " . $this->getToAddresses()[0][0]);
            } else {
                error_log("Email sending failed: " . $this->ErrorInfo);
            }
            return $result;
        } catch (Exception $e) {
            error_log("Mailer Exception: " . $e->getMessage());
            error_log("Mailer Error Info: " . $this->ErrorInfo);
            return false;
        }
    }
}
?>