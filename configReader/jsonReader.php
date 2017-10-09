<?php namespace configReader;

    class jsonReader
    {
        public static function reade($file)
        {
            try
            {
                if ($file === '' || $file === NULL)
                {
                    throw new \Exception("<div class='alert alert-danger warning' dir='rtl'><h5>فایل حاوی پیغام ها در سیستم وجود ندارد.این فایل برای نمایش پیغام های سیستمی لازم است لطفا نام فایل را وارد کنید.</h5></div>");
                }
                else
                {
                    $filPath = root.$file;
                    $fileInfo = pathinfo($file);
                    try
                    {
                        if (!isset($fileInfo['extension']) || $fileInfo['extension'] !== 'json')
                        {
                            throw new \Exception();
                        }
                        else
                        {
                            try
                            {
                                if (!is_file($filPath) || !is_readable($filPath))
                                {
                                    throw new \Exception();
                                }
                                else
                                {
                                    return json_decode(file_get_contents($filPath), TRUE);
                                }
                            }
                            catch (\Exception $error)
                            {
                                throw new \Exception("<div class='alert alert-danger warning' dir='rtl'><h5>فایل وارد شده بنا به دلایلی قابلیت خواندن توسط سیستم را ندارد.</h5></div>"); //todo: create msg;
                            }
                        }
                    }
                    catch (\Exception $error)
                    {
                        throw new \Exception("<div class='alert alert-danger warning' dir='rtl'><h5>فرمت فایل شناسایی نشد.فرمت فایل حتما باید <span style='color: red;'>json</span> باشد و به همراه اسم فایل نوشته شود. به عنوان نمونه: message.json</h5></div>");
                    }
                }
            }
            catch (\Exception $error)
            {
                return $error -> getMessage();
            }
        }
    }