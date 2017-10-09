<?php
    use configReader\jsonReader;
    use functions\Model;

    require_once '../../configs/configs.php';
    require_once root.'helperFunctions/functions.php';
    require_once root.'helperFunctions/sql_counter.php';
    require_once root.'vendor/autoload.php';
    require_once root.'admin/news/check_register_news.php';


    if (isset($_POST))
    {
        $id = NULL;
        $_POST = json_decode(file_get_contents('php://input'), TRUE);
        $id = $_POST['id'];

        $data_0 =
            [
                'fields' => [],
                'values' => [$id],
                'query' => 'DELETE FROM `news` WHERE `news`.`id` = ?;'
            ];
        $result_0 =  Model::run() -> c_find($data_0);
        if ($result_0)
        {
            echo '
        
    <table>
                <tr>
                    <th>ردیف</th>
                    <th>متن خبر</th>
                    <th>وضعیت نمایش خبر</th>
                    <th>اصلاح</th>
                    <th>حذف</th>
                </tr>';

                    $data =
                        [
                            'fields' => [],
                            'values' => [],
                            'query' => 'SELECT * FROM `news` ORDER BY `news`.`id` DESC;'
                        ];
                    $result =  Model::run() -> c_find($data);
                    for ($i = 0; $i < count($result); $i++)
                    {
                        echo '
                            <tr>
                                <td>'.($i + 1).'</td>
                                <td>'.$result[$i]['text'].'</td>';

                        if ($result[$i]['status'] == 0)
                        {
                            echo '
                                <td>
                                    <span class="status_result news_hide"><i class="fa fa-times" aria-hidden="true"></i>خبر غیر قابل نمایش است</span>
                                    <a class="change_status" href="'._base_url.'change_status.php?id='.$result[$i]['id'].'">خبر را نمایش بده</a>
                                </td>
                            ';
                        }

                        if ($result[$i]['status'] == 1)
                        {
                            echo '
                                <td>
                                    <span class="status_result news_show"><i class="fa fa-check" aria-hidden="true"></i>خبر قابل نمایش است</span>
                                    <a class="change_status" href="'._base_url.'change_status.php?id='.$result[$i]['id'].'">خبر را مخفی کن</a>
                                </td>
                            ';
                        }

                        echo '
                                <td><a href="'._base_url.'news_update.php?id='.$result[$i]['id'].'">اصلاح خبر</a></td>
                                <td><a href="#?" class="delete_news" onclick="delNews('.$result[$i]['id'].')" data-id="'.$result[$i]['id'].'">حذف خبر</a></td>
                            </tr>
                        ';
                    }
                    echo '
</table>';
        }
    }

