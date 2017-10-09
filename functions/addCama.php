<?php namespace functions; use configReader\jsonReader;

    class addCama
    {
        public function cama ($price)
        {
            $n = NULL;
            $k = 0;

            for ($i = strlen($price) - 1; $i >= 0; $i--)
            {
                $k++;
                if (($k % 3) == 0)
                {
                    if ($i == 0)
                    {
                        $n = $price[$i].$n;
                    }
                    else
                    {
                        $n .= ', '.$price[$i];
                    }
                }
                else
                {
                    $n = $price[$i].$n;
                }
            }
            return $n;
        }
    }