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
use Symfony\Component\HttpFoundation\Session\Session;


class FacebookController extends Controller
{

    /**
     * @Route("/facebook", name="facebook")
     */
    public function index2Action(Request $request)
    {

        $host = 'http://'.$request->getHost();
        if ( $this->container->get( 'kernel' )->getEnvironment() == 'dev' ):
            $host .= '/app_dev.php';
        endif;



        #validar que session este inicializado
        if(!session_id()) {
            session_start();
        }

        $fb = new Facebook([
            'app_id' => '460859080767262',
            'app_secret' => '69915f389cdfa981be8dfb98276cbaf2',
            'default_graph_version' => 'v2.5',
        ]);

        $helper = $fb->getRedirectLoginHelper();

        $permissions = ['email']; // Optional permissions
        $loginUrl = $helper->getLoginUrl("$host/fb-callback", $permissions);

        $enlaceFacebook = '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';

        #obtener datos si esta logeado
        $user = null;
        if(!empty($_SESSION['fb_access_token'])):
            $fb = new Facebook([
                'app_id' => '460859080767262',
                'app_secret' => '69915f389cdfa981be8dfb98276cbaf2',
                'default_graph_version' => 'v2.5',
            ]);

            try {
                // Returns a `Facebook\FacebookResponse` object
                $response = $fb->get('/me?fields=id,name,email', $_SESSION['fb_access_token']);
            } catch(FacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
            } catch(FacebookSDKException $e) {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }
            $user = $response->getGraphUser();
        endif;


        // replace this example code with whatever you need
        return $this->render('facebook/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir') . '/..'),
            'enlaceFacebook' => $enlaceFacebook,
            'user' => $user
        ));
    }

    /**
     * @Route("/fb-callback", name="fb-callback")
     */
    public function callbackAction(Request $request)
    {
        #validar que session este inicializado
        if(!session_id()) {
            session_start();
        }

        $fb = new Facebook([
            'app_id' => '460859080767262',
            'app_secret' => '69915f389cdfa981be8dfb98276cbaf2',
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
        $tokenMetadata->validateAppId('460859080767262'); // Replace {app-id} with your app id
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
        $session = new Session();
        $session->set('fb_access_token', (string)$accessToken);




        #get info user
        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->get('/me?fields=id,name,email', $accessToken);
        } catch(FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $user = $response->getGraphUser();

        echo '<br><br>Name: ' . $user['name'];
        echo '<br><br>Email: ' . $user['email'];

        // User is logged in with a long-lived access token.
        // You can redirect them to a members-only page.
        //header('Location: https://example.com/members.php');
        //echo $this->generateUrl('loged');exit;
        return $this->redirect($this->generateUrl('facebook'));

    }

    /**
     * @Route("/loged", name="loged")
     */
    public function logedAction(Request $request)
    {
        if(!empty($_SESSION['fb_access_token'])):
            $fb = new Facebook([
                'app_id' => '537579346410151',
                'app_secret' => '8967e3e0877c51297ecf269773928a29',
                'default_graph_version' => 'v2.5',
            ]);

            try {
                // Returns a `Facebook\FacebookResponse` object
                $response = $fb->get('/me?fields=id,name,email', $_SESSION['fb_access_token']);
            } catch(FacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
            } catch(FacebookSDKException $e) {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }

            $user = $response->getGraphUser();

            echo '<br><br>Name: ' . $user['name'];
            echo '<br><br>Email: ' . $user['email'];

        else:
            echo "deslogeado";
        endif;



        exit;
    }

    /**
     * @Route("/logout-user", name="logout-user")
     */

    public function logout(){

        $session = new Session();
        $session->remove('fb_access_token');
        unset($_SESSION['fb_access_token']);

        return $this->redirect($this->generateUrl('facebook'));

    }



    }