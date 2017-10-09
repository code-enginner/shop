<?php

    //*** Dumper Function
    function dump($data = NULL, $die = FALSE, $dump = FALSE)
    {
        switch ($dump)
        {
            case FALSE:
                switch ($die)
                {
                    case FALSE:
                        echo '<div dir="ltr" style="direction: ltr !important; text-align: left;">';
                        echo '<pre dir="ltr" style="direction: ltr !important; text-align: left;">';
                        print_r($data);
                        echo '</pre>';
                        echo '</div>';
                        break;
                    case TRUE:
                        echo '<div dir="ltr" style="direction: ltr !important; text-align: left;">';
                        echo '<pre dir="ltr" style="direction: ltr !important; text-align: left;">';
                        print_r($data);
                        echo '</pre>';
                        echo '</div>';
                        exit();
                        break;
                }
                break;
            case TRUE:
                switch ($die)
                {
                    case FALSE:
                        echo '<div dir="ltr">';
                        echo '<pre>';
                        var_dump($data);
                        echo '</pre>';
                        echo '</div>';
                        break;
                    case TRUE:
                        echo '<div dir="ltr">';
                        echo '<pre>';
                        var_dump($data);
                        echo '</pre>';
                        echo '</div>';
                        exit();
                        break;
                }
                break;
        }
    }


    //*** Data Wrapper for SQL Query
    function wrapData($data, $bind = FALSE, $is_insert = FALSE, $wrapSign = '`', $surround = 'both')
    {
        $surround = strtoupper($surround);
        if ($bind === FALSE)
        {
            goto A;
        }
        elseif($bind === TRUE)
        {
            goto B;
        }

        A:
        {
            switch ($surround)
            {
                case 'BOTH':
                    if($is_insert === TRUE)
                    {
                        foreach ($data as $key => $value)
                        {
                            $data[$key] = $wrapSign.$value.$wrapSign.'.'.':'.$value;
                        }
                        //$data = implode(',', $data);
                        return $data;
                    }
                    elseif ($is_insert === FALSE)
                    {
                        foreach ($data as $key => $value)
                        {
                            $data[$key] = $wrapSign.$key.$wrapSign;
                        }
                        return $data;
                    }
                    break;
                case 'L':
                    if ($is_insert === FALSE)
                    {
                        foreach ($data as $key => $value)
                        {
                            $data[$key] = $wrapSign.$key;
                        }
                        return $data;
                    }
                    echo '<div dir="ltr" class="en_hint"><p>The Last argument should be `false`.</p></div>';
                    return FALSE;
                    break;
                default:
                    echo '<div dir="ltr" class="en_hint"><p>The surround argument should be `BOTH` or `L`.</p></div>';
                    return FALSE;
                    break;
            }
        }

        B:
        {
            if($is_insert === TRUE)
            {
                foreach ($data as $key => $value)
                {
                    $data[$key] = ':'.$key;
                }
                $data = implode(', ', $data);
                return $data;
            }
            echo '<div dir="ltr" class="en_hint"><p>The `is_insert` argument should be `true`.</p></div>';
            return FALSE;
        }
    }


    //*** Session Test for checking admin login
    function is_login()
    {
         return (isset($_SESSION['lName']) && isset($_SESSION['fName']) && isset($_SESSION['email'])) ?  TRUE : FALSE;
    }