<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * twitter.php
 *
 * The twitter controller
 *
 * @author Simon Emms <simon@simonemms.com>
 */
class twitter_test extends CI_Controller {
    
    
    
    
    /**
     * Construct
     * 
     * Set up the Twitter library
     */
    public function __construct() {
        
        parent::__construct();
        
        /* Load the Twitter library */
        $this->load->library('tweetigniter');
        
        /* Set it to show errors */
        //$this->tweetigniter->debug();
        
    }
    




    /**
     * Auth
     * 
     * Authorizes the Twitter login.
     * 
     * Ordinarily, much of this would be done
     * in a view file, but this is just a demo
     *
     * @author Simon Emms <simon@simonemms.com>
     */
    public function index() {
        
        /* Check we're logged in */
        if($this->tweetigniter->is_logged_in()) {
            /* We are */
            
            /* Show my timeline */
            $arrTwitter = $this->tweetigniter->fetch_home_timeline();
            
            /* Show the given user's timeline */
            //$arrTwitter = $this->tweetigniter->fetch_user_timeline(null, 'riggerthegeek');
            
            /* Search Twitter */
            //$arrTwitter = $this->tweetigniter->search('twitter');
            
            /* Post a Tweet */
            //$this->tweetigniter->post_tweet('<plug>TweetIgniter is brilliant</plug> https://github.com/riggerthegeek/TweetIgniter');
            
            /* Parse the text to add */
            $arrTwitter = $this->tweetigniter->parse_tweet($arrTwitter);
            
            $tweets = '';
            if(count($arrTwitter) > 0) {
                foreach($arrTwitter as $twitter) {
                    $tweets .= '<b>'.$this->tweetigniter->parse_username($twitter['user']['screen_name'], null, true).'</b><br />';
                    $tweets .= $twitter['parsed_text'].'<br /><hr />';
                }
            }
            
            echo $tweets;exit;
            
        } else {
            /* We're not - display login */
            echo '<a href="'.site_url('twitter_test/login').'">
                <img src="https://dev.twitter.com/sites/default/files/images_documentation/sign-in-with-twitter_0.png" alt="Login with Twitter" />
            </a>';
        }

    }
    
    
    
    
    
    
    /**
     * Login
     * 
     * Manage the site login
     */
    public function login() {
        /* Are we logged in */
        if($this->tweetigniter->is_logged_in()) {
            /* Yes - back to homepage */
            redirect(site_url('twitter_test'));
        } else {
            /* No - login */
            $this->tweetigniter->login();
        }
    }
    
    
    
    
    
    
    
    /**
     * Logout
     * 
     * Logout and redirect to home
     * 
     * @author Simon Emms <simon@simonemms.com> 
     */
    public function logout() {
        
        $this->tweetigniter->logout();
        
        redirect('twitter_test');
        
    }

}

/* End of twitter_test.php */