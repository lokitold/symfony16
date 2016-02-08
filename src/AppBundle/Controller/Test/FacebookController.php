<?php

namespace AppBundle\Controller\Test;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Tools\Pagination\Paginator;
use AppBundle\Entity\Post;
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;


class FacebookController extends Controller
{
    /**
     * @Route("/facebook", name="facebook")
     */
    public function index2Action(Request $request)
    {

        $fb = new Facebook([
            'app_id' => '537579346410151',
            'app_secret' => '8967e3e0877c51297ecf269773928a29',
            'default_graph_version' => 'v2.5',
        ]);

        $helper = $fb->getRedirectLoginHelper();

        $permissions = ['email']; // Optional permissions
        $loginUrl = $helper->getLoginUrl('http://local.symfony16.pe/app_dev.php/fb-callback', $permissions);

        ##correction bug
        #if(!isset($_SESSION))
        #{
        #    session_start();
        #}
        /*foreach ($_SESSION as $k=>$v) {
            if(strpos($k, "FBRLH_")!==FALSE) {
                if(!setcookie($k, $v)) {
                    //what??
                } else {
                    $_COOKIE[$k]=$v;
                }
            }
        }*/

        $enlaceFacebook = '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';


        // replace this example code with whatever you need
        return $this->render('facebook/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
            'enlaceFacebook' => $enlaceFacebook
        ));
    }

    /**
     * @Route("/fb-callback", name="fb-callback")
     */
    public function callbackAction(Request $request)
    {

        #correction bug
        #foreach ($_COOKIE as $k=>$v) {
        #    if(strpos($k, "FBRLH_")!==FALSE) {
        #        $_SESSION[$k]=$v;
        #    }
        #}

        $fb = new Facebook([
            'app_id' => '537579346410151',
            'app_secret' => '8967e3e0877c51297ecf269773928a29',
            'default_graph_version' => 'v2.5',
        ]);

        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch (FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch (FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if (!isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }

        // Logged in
        echo '<h3>Access Token</h3>';
        var_dump($accessToken->getValue());

        // The OAuth 2.0 client handler helps us manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();

        // Get the access token metadata from /debug_token
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);
        echo '<h3>Metadata</h3>';
        var_dump($tokenMetadata);

        // Validation (these will throw FacebookSDKException's when they fail)
        $tokenMetadata->validateAppId('537579346410151'); // Replace {app-id} with your app id
        // If you know the user ID this access token belongs to, you can validate it here
        //$tokenMetadata->validateUserId('123');
        $tokenMetadata->validateExpiration();

        if (!$accessToken->isLongLived()) {
            // Exchanges a short-lived access token for a long-lived one
            try {
                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
            } catch (FacebookSDKException $e) {
                echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
                exit;
            }

            echo '<h3>Long-lived</h3>';
            var_dump($accessToken->getValue());
        }

        $_SESSION['fb_access_token'] = (string)$accessToken;
        exit;
// User is logged in with a long-lived access token.
// You can redirect them to a members-only page.
//header('Location: https://example.com/members.php');*/

    }


}