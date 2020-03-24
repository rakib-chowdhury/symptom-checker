<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Basic_lib
{
    public function __construct() {

        // get main CI object
        $this->CI = & get_instance();
        $this->CI->load->model('basic_model');
        $this->CI->load->model('users/user_model', 'user_model');
        date_default_timezone_set('Asia/Dhaka');
    }
    function get_browser(){
        $u_agent = $_SERVER['HTTP_USER_AGENT'];
        $bname = 'Unknown';
        $platform = 'Unknown';
        $version= "";
        $windows_version = 'Unknown';
        $os_array       = array('/windows phone 8/i'    =>  'Windows Phone 8',
            '/windows phone os 7/i' =>  'Windows Phone 7',
            '/windows NT 10.0/'     =>  'Windows 10',
            '/windows NT 6.3/i'     =>  'Windows 8.1',
            '/windows NT 6.2/i'     =>  'Windows 8',
            '/windows NT 6.1/i'     =>  'Windows 7',
            '/windows NT 6.0/i'     =>  'Windows Vista',
            '/windows NT 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows NT 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows NT 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile');
        foreach ($os_array as $row)
        {
            if(preg_match('/Windows NT /i', $row))
            {
                $windows_version = $row;
            }
        }
        if (preg_match('/android/i', $u_agent)) {
            $platform = 'android';
        }
        elseif (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        }
        elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        }
        elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }

        if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
        {
            $bname = 'Internet Explorer';
            $ub = "MSIE";
        }
        elseif(preg_match('/UCBrowser/i',$u_agent))
        {
            $bname = 'UCBrowser';
            $ub = "UCBrowser";
        }
        elseif(preg_match('/Opera/i',$u_agent))
        {
            $bname = 'Opera';
            $ub = "Opera";
        }
        elseif(preg_match('/Netscape/i',$u_agent))
        {
            $bname = 'Netscape';
            $ub = "Netscape";
        }
        elseif(preg_match('/Chrome/i',$u_agent))
        {
            $bname = 'Google Chrome';
            $ub = "Chrome";
        }
        elseif(preg_match('/Safari/i',$u_agent))
        {
            $bname = 'Apple Safari';
            $ub = "Safari";
        }
        elseif(preg_match('/Firefox/i',$u_agent))
        {
            $bname = 'Mozilla Firefox';
            $ub = "Firefox";
        }


        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
            ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if(!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }

        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
                $version= $matches['version'][0];
            }
            else {
                $version= $matches['version'][1];
            }
        }
        else {
            $version= $matches['version'][0];
        }

        if ($version==null || $version=="") {$version="?";}

        return array(
            'userAgent' => $u_agent,
            'name'      => $bname,
            'version'   => $version,
            'platform'  => $platform,
            'pattern'    => $pattern,
            'windows_version' => $windows_version
        );

    }

    public function convert_date_time_to_millisecond($date, $time)
    {
        $concat = $date.' '.$time;
        return strtotime($concat)*1000;
    }

    public function format_date($date)
    {
        $timestamp = strtotime($date);
        $formatted_date = date('Y-m-d', $timestamp);
        return $formatted_date;
    }

    public function format_date_for_view($date)
    {
        $timestamp = strtotime($date);
        $formatted_date = date('d/m/Y', $timestamp);
        return $formatted_date;
    }
    public function format_date_for_view_pages($date)
    {
        $timestamp = strtotime($date);
        $formatted_date = date('d F, Y', $timestamp);
        return $formatted_date;
    }
    public function convert_date_to_millisecond($date)
    {
        return strtotime($date)*1000;
    }
    public function millisecond_to_date($millisecond_time)
    {
        $datetime = $millisecond_time/1000;
        $datetime = date('Y-m-d', $datetime);

        return $datetime;
    }

    public function get_user_permissions($user_name){
        $get_permissions = $this->CI->user_model->get_user_wise_permissions($user_name);
        $permission_data = array();
        if($get_permissions->num_rows() > 0){
            foreach ($get_permissions->result() as $row){
                array_push($permission_data, $row->permission_id);
            }
        }
        return $permission_data;
    }
    public function check_permission($permission_name){
        if($_SESSION['is_super_user'] == SUPER_ADMIN || in_array(ADMIN, $_SESSION['user_roles'])){
            return true;
        }else{
            $get_permission_id = $this->CI->basic_model->get_where('id', "name='$permission_name'", 'permissions')->row();
            if($get_permission_id){
                if(in_array($get_permission_id->id, $_SESSION['user_permissions'])){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }
    }

    public function get_start_date($month, $year)
    {
        $temp_date = $year.'-'.$month.'-'.'05';
        $first_date = date('01-m-Y', strtotime($temp_date));
        return $first_date;
    }
    public function get_end_date($month, $year)
    {
        $temp_date = $year.'-'.$month.'-'.'05';
        $last_date = date('t-m-Y', strtotime($temp_date));
        return $last_date;
    }
}
