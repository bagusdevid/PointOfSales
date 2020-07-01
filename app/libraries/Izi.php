<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 *  ==============================================================================
 *  Author  : Ismail Marzuqi
 *  Email   : iesien22@yahoo.com
 *  ==============================================================================
 */

class Izi
{

    public function __construct() {

    }

    public function __get($var) {
        return get_instance()->$var;
    }

    public function clear_tags($str) {
        return htmlentities(strip_tags($str, '<span><div><a><br><p><b><i><u><img><blockquote><small><ul><ol><li><hr><big><pre><code><strong><em><table><tr><td><th><tbody><thead><tfoot><h3><h4><h5><h6>'), ENT_QUOTES | ENT_XHTML | ENT_HTML5, 'UTF-8');
    }

    public function decode_html($str) {
        return html_entity_decode($str, ENT_QUOTES | ENT_XHTML | ENT_HTML5, 'UTF-8');
    }


    public function formatMoney($number, $decimal = false) {
        if ($this->Settings->sac) {
            return ($this->Settings->display_symbol == 1 ? $this->Settings->symbol : '') .
            $this->formatSAC($this->formatDecimal($number)) .
            ($this->Settings->display_symbol == 2 ? $this->Settings->symbol : '');
        }
        $decimals = $decimal !== false ? $decimal : $this->Settings->decimals;
        $ts = $this->Settings->thousands_sep == '0' ? ' ' : $this->Settings->thousands_sep;
        $ds = $this->Settings->decimals_sep;
        return ($this->Settings->display_symbol == 1 ? $this->Settings->symbol : '') .
        number_format($number, $decimals, $ds, $ts) .
        ($this->Settings->display_symbol == 2 ? $this->Settings->symbol : '');
    }

    public function formatQuantity($number, $decimals = null) {
        if (!$decimals) {
            $decimals = $this->Settings->qty_decimals;
        }
        if ($this->Settings->sac) {
            return $this->formatSAC($this->formatDecimal($number, $decimals));
        }
        $ts = $this->Settings->thousands_sep == '0' ? ' ' : $this->Settings->thousands_sep;
        $ds = $this->Settings->decimals_sep;
        return number_format($number, $decimals, $ds, $ts);
    }

    public function formatNumber($number, $decimals = null) {
        if (!$decimals) {
            $decimals = $this->Settings->decimals;
        }
        if ($this->Settings->sac) {
            return $this->formatSAC($this->formatDecimal($number, $decimals));
        }
        $ts = $this->Settings->thousands_sep == '0' ? ' ' : $this->Settings->thousands_sep;
        $ds = $this->Settings->decimals_sep;
        return number_format($number, $decimals, $ds, $ts);
    }

    public function formatDecimal($number, $decimals = null) {
        if (!is_numeric($number)) {
            return null;
        }
        if (!$decimals) {
            $decimals = $this->Settings->decimals;
        }
        return number_format($number, $decimals, '.', '');
    }

    public function roundNumber($number, $toref = NULL) {
        switch($toref) {
            case 1:
                $rn = round($number * 20)/20;
                break;
            case 2:
                $rn = round($number * 2)/2;
                break;
            case 3:
                $rn = round($number);
                break;
            case 4:
                $rn = ceil($number);
                break;
            default:
                $rn = $number;
        }
        return $rn;
    }

    public function unset_data($ud) {
        if($this->session->userdata($ud)) {
            $this->session->unset_userdata($ud);
            return true;
        }
        return FALSE;
    }

    public function hrsd($sdate) {
        if ($sdate) {
            return date($this->Settings->dateformat, strtotime($sdate));
        }
        return FASLE;
    }

    public function hrld($ldate) {
        if ($ldate) {
            return date($this->Settings->dateformat.' '.$this->Settings->timeformat, strtotime($ldate));
        }
        return FALSE;
    }

    public function send_email($to, $subject, $message, $from = NULL, $from_name = NULL, $attachment = NULL, $cc = NULL, $bcc = NULL) {
        list($user, $domain) = explode('@', $to);
        if ($domain != 'tecdiary.com' || DEMO) {
            if ($this->Settings->protocol == 'smtp') {
                $this->load->library('tec_mail');
                return $this->izi_mail->send_mail($to, $subject, $message, $from, $from_name, $attachment, $cc, $bcc);
            }
            $this->load->library('email');
            $config['protocol'] = $this->Settings->protocol;
            $config['mailtype'] = "html";
            $config['newline'] = "\r\n";
            if ($this->Settings->protocol == 'sendmail') {
                $config['mailpath'] = $this->Settings->mailpath;
            }
            $this->email->initialize($config);

            if ($from && $from_name) {
                $this->email->from($from, $from_name);
            } elseif ($from) {
                $this->email->from($from, $this->Settings->site_name);
            } else {
                $this->email->from($this->Settings->default_email, $this->Settings->site_name);
            }

            $this->email->to($to);
            if ($cc) {
                $this->email->cc($cc);
            }
            if ($bcc) {
                $this->email->bcc($bcc);
            }
            $this->email->subject($subject);
            $this->email->message($message);
            if ($attachment) {
                if (is_array($attachment)) {
                    $this->email->attach($attachment['file'], '', $attachment['name'], $attachment['mine']);
                } else {
                    $this->email->attach($attachment);
                }
            }

            if ($this->email->send()) {
                return TRUE;
            } else {
                throw new Exception($this->email->print_debugger());
                return FALSE;
            }
        }
    }

    public function print_arrays() {
        $args = func_get_args();
        echo "<pre>";
        foreach($args as $arg){
            print_r($arg);
        }
        echo "</pre>";
        die();
    }

    public function getUsers() {
        return $this->site->getUsers();
    }

    public function getUser($user_id = NULL) {
        return $this->site->getUser($user_id);
    }

    public function logged_in() {
        return (bool) $this->session->userdata('identity');
    }

    public function in_group($check_group, $id = false) {
        if ( ! $id) { $id = $this->session->userdata('user_id'); }
        $group = $this->site->getUserGroup($id);
        if($group && $group->name === $check_group) {
            return TRUE;
        }
        return FALSE;
    }

    private function _rglobRead($source, &$array = array()) {
        if (!$source || trim($source) == "") {
            $source = ".";
        }
        foreach ((array)glob($source . "/*/") as $key => $value) {
            $this->_rglobRead(str_replace("//", "/", $value), $array);
        }
        $hidden_files = glob($source . ".*") AND $htaccess = preg_grep('/\.htaccess$/', $hidden_files);
        $files = array_merge(glob($source . "*.*"), $htaccess);
        foreach ($files as $key => $value) {
            $array[] = str_replace("//", "/", $value);
        }
    }

    private function _zip($array, $part, $destination, $output_name = 'sma') {
        $zip = new ZipArchive;
        @mkdir($destination, 0777, true);

        if ($zip->open(str_replace("//", "/", "{$destination}/{$output_name}" . ($part ? '_p' . $part : '') . ".zip"), ZipArchive::CREATE)) {
            foreach ((array)$array as $key => $value) {
                $zip->addFile($value, str_replace(array("../", "./"), NULL, $value));
            }
            $zip->close();
        }
    }

    public function zip($source = NULL, $destination = "./", $output_name = 'sma', $limit = 5000) {
        if (!$destination || trim($destination) == "") {
            $destination = "./";
        }

        $this->_rglobRead($source, $input);
        $maxinput = count($input);
        $splitinto = (($maxinput / $limit) > round($maxinput / $limit, 0)) ? round($maxinput / $limit, 0) + 1 : round($maxinput / $limit, 0);

        for ($i = 0; $i < $splitinto; $i++) {
            $this->_zip(array_slice($input, ($i * $limit), $limit, true), $i, $destination, $output_name);
        }

        unset($input);
        return;
    }

    public function unzip($source, $destination = './') {

        // @chmod($destination, 0777);
        $zip = new ZipArchive;
        if ($zip->open(str_replace("//", "/", $source)) === true) {
            $zip->extractTo($destination);
            $zip->close();
        }
        // @chmod($destination,0755);

        return TRUE;
    }

    public function view_rights($check_id, $js = NULL, $page = NULL) {
        if (!$this->Admin) {
            if ($check_id != $this->session->userdata('user_id')) {
                $this->session->set_flashdata('error', $this->data['access_denied']);
                if ($js) {
                    die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . ($page ? $page : (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : site_url('welcome'))) . "'; }, 10);</script>");
                } else {
                    redirect($page ? $page : (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : 'welcome'));
                }
            }
        }
        return TRUE;
    }

    public function dd() {
        die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : site_url('pos')) . "'; }, 10);</script>");
    }

    public function get_base64($file_name) {
        $type = pathinfo($file_name, PATHINFO_EXTENSION);
        $data = file_get_contents($file_name);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }

    public function save_barcode($text = null, $bcs = 'code128', $height = 56, $stext = 1) {
        $drawText = ($stext != 1) ? false : true;
        $this->load->library('zend');
        $this->zend->load('Zend/Barcode');
        $barcodeOptions = array('text' => $text, 'barHeight' => $height, 'drawText' => $drawText, 'factor' => 1);
        $rendererOptions = array('imageType' => 'jpg', 'horizontalPosition' => 'center', 'verticalPosition' => 'middle');
        $imageResource = Zend_Barcode::draw($bcs, 'image', $barcodeOptions, $rendererOptions);
        // $save = 'uploads/barcode'.$this->session->userdata('user_id').'png';
        // imagepng($imageResource, $save);
        ob_start();
        imagepng($imageResource);
        $imagedata = ob_get_contents();
        ob_end_clean();
        return 'data:image/png;base64,'.base64_encode($imagedata);
    }

    public function send_json($data) {
        header('Content-Type: application/json');
        die(json_encode($data));
        exit;
    }

    public function formatSAC($num)
    {
        $pos = strpos((string) $num, ".");
        if ($pos === false) {
            $decimalpart = "00";
        } else {
            $decimalpart = substr($num, $pos + 1, 2);
            $num = substr($num, 0, $pos);
        }

        if (strlen($num) > 3 & strlen($num) <= 12) {
            $last3digits = substr($num, -3);
            $numexceptlastdigits = substr($num, 0, -3);
            $formatted = $this->makecomma($numexceptlastdigits);
            $stringtoreturn = $formatted . "," . $last3digits . "." . $decimalpart;
        } elseif (strlen($num) <= 3) {
            $stringtoreturn = $num . "." . $decimalpart;
        } elseif (strlen($num) > 12) {
            $stringtoreturn = number_format($num, 2);
        }

        if (substr($stringtoreturn, 0, 2) == "-,") {
            $stringtoreturn = "-" . substr($stringtoreturn, 2);
        }

        return $stringtoreturn;
    }
}
