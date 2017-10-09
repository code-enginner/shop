<?php namespace functions;

    use configReader\jsonReader;


    class Model
    {
        private $DBConfig;
        private $sysMsg;
        private $tblPerfix = NULL;
        public $primaryKey = [];

        private function db_get_configs()
        {
            $this -> DBConfig = jsonReader::reade('DBConfigs.json');
            return $this -> DBConfig;
        }


        private function systemMessage()
        {
            $this -> sysMsg = jsonReader::reade('systemMessage.json');
            return $this -> sysMsg;
        }


        private function getConnection()
        {
            $this -> db_get_configs();
            $this -> systemMessage();
            try
            {
                $this -> tblPerfix = $this -> DBConfig['database']['tablePerfix'];
                $username = $this -> DBConfig['database']['username'];
                $password = $this -> DBConfig['database']['password'];
                $dsn = "{$this -> DBConfig['database']['driver']}: host={$this -> DBConfig['database']['host']};dbname={$this -> DBConfig['database']['databaseName']};charset={$this -> DBConfig['database']['charSet']};";
                $connection = new \PDO($dsn, $username, $password);
                $connection ->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                $connection -> exec('SET NAMES utf8');
                return $connection;
            }
            catch (\Exception $error)
            {
                return $this -> sysMsg['serverError'][0]['msg0'];
            }
        }


        public static function run()
        {
            $class = get_class();
            return new $class;
        }


        public function rowCounter($arguments)
        {
            $connection = $this -> getConnection();
            $fields = [];
            $values = [];
            $query = NULL;
            $tableName = NULL;
            $rows_num_mode1 = NULL;
            $rows_num_mode2 = NULL;

//            dump($arguments, TRUE);
            foreach ($arguments as $key => $value)
            {
                switch ($key)
                {
                    case 'fields':
                        $fields = $arguments[$key];
                        break;
                    case 'values':
                        $values = $arguments[$key];
                        break;
                    case 'tableName':
                        $tableName = $arguments[$key];
                        break;
                    case 'query':
                        $query = $arguments[$key];
                        break;
                }
            }

            if ($fields === [])
            {
                goto A;
            }
            else
            {

            }

            A:
            {
                $result = $connection -> prepare($query);
                $result -> execute($values);
                $rows_num_mode1 = $result -> rowCount();
                $rows_num_mode2 = $result -> fetchColumn();
                try
                {
                    if ($result)
                    {
                        $connection = NULL;
                        return array
                        (
                            $rows_num_mode1,
                            $rows_num_mode2
                        );
                    }
                    throw new \Exception($this -> sysMsg['serverError'][1]['msg1']);
                }
                catch (\Exception $error)
                {
                    $connection = NULL;
                    return $error -> getMessage();
                }
            }
        }

        public function complex($arguments, $extra = NULL)
        {
            $connection = $this -> getConnection();
            $fields = [];
            $values = [];
            $query = NULL;
            $tableName = NULL;

//            dump($arguments, TRUE);
            foreach ($arguments as $key => $value)
            {
                switch ($key)
                {
                    case 'fields':
                        $fields = $arguments[$key];
                        break;
                    case 'values':
                        $values = $arguments[$key];
                        break;
                    case 'tableName':
                        $tableName = $arguments[$key];
                        break;
                    case 'query':
                        $query = $arguments[$key];
                        break;
                }
            }

            if ($fields === [])
            {
                goto A;
            }
            else
            {

            }

            A:
            {
                $result = $connection -> prepare($query);
                $result -> execute($values);
                try
                {
                    if ($result)
                    {
                        $connection = NULL;
                        return $result -> fetchAll(\PDO::FETCH_ASSOC);
                    }
                    throw new \Exception($this -> sysMsg['serverError'][1]['msg1']);
                }
                catch (\Exception $error)
                {
                    $connection = NULL;
                    return $error -> getMessage();
                }
            }
        }

        public function findBy($arguments)
        {
            // todo: use try-catch to handle if $arguments is empty;

            dump($arguments, TRUE);
        }


        public function select($arguments)
        {
            // todo: use try-catch to handle if $arguments is empty;

            $connection = $this -> getConnection();
            $data = [];
            $mathOp = [];       // $mathOp:   array of math operator like  = , <> , != , ...
            $logicOp = [];      // $logicOp:  array of logical operators like  AND , OR , ...
            $filedName = [];
            $filedValue = [];
            $tableName = NULL;
            $fetchAll = NULL;

            foreach ($arguments as $key => $value)
            {
                switch ($key)
                {
                    case 'data':
                        $data = $arguments[$key];
                        break;
                    case 'tableName':
                        $tableName = $arguments[$key];
                        $tableName = $this -> tblPerfix.$tableName;
                        break;
                    case 'mathOp':
                        $mathOp = $arguments[$key];
                        break;
                    case 'logicOp':
                        $logicOp = $arguments[$key];
                        break;
                    case 'fetchAll':
                        $fetchAll = $arguments[$key];
                        break;
                }
            }
            // todo: set try and catch for when $data is empty or $data's count is lower or equal then 2

            if ($fetchAll === TRUE)
            {
                goto FETCH_ALL;
            }
            elseif ($fetchAll === FALSE)
            {
                try
                {
                    if ($data === [] || $data === NULL)
                    {
                        throw new \Exception(); //todo: create msg if: $data is empty;
                    }
                    else
                    {
                        try
                        {
                            if (!is_array($data))
                            {
                                throw new \Exception();
                            }
                            else
                            {
                                foreach ($data as $fName => $val)
                                {
                                    $filedName[] = $fName;
                                    $filedValue[] = $val;
                                }
                            }
                        }
                        catch (\Exception $error)
                        {
                            throw new \Exception($this -> sysMsg['serverError'][4]['msg4']); // get an error when $data is not an array;
                        }
                    }
                }
                catch (\Exception $error)
                {
                    return $error -> getMessage();
                }
            }

            foreach ($mathOp as $key => $value)
            {
                $mathOp[$key] = ' ' . $value . ' ';     // add space to begin and end of each index in $mathOp
            }

            foreach ($logicOp as $key => $value)
            {
                $logicOp[$key] = strtoupper(' ' . $value . ' ');    // change each elem in $logicOp to uppercase
            }

            for ($i = 0; $i < count($filedName); $i++)      // these two loops is for making query string
            {
                if (isset($mathOp[$i]) && count($mathOp[$i]) > 0)
                {
                    $filedName[$i] = '`'.$filedName[$i].'`'.$mathOp[$i].':'.$filedName[$i];
                }
                else
                {
                    $filedName[$i] = '`'.$filedName[$i].'`'.$mathOp[$i - $i].':'.$filedName[$i];
                }
            }

            for ($i = 0; $i < count($filedName); $i++)
            {
                if (isset($logicOp[$i]) && count($logicOp) > 0)
                {
                    $filedName[$i] = $filedName[$i].$logicOp[$i];
                }
//                else
//                {
//                    $filedName[$i] = $filedName[$i].$logicOp[$i - $i];
//                }
            }

            $filedName = implode('', $filedName);
            $arr = [' AND ', ' OR ', ' NOT ', ' LIKE', 'ORDER BY '];
            for ($i = 0; $i < count($arr); $i++)
            {
                $filedName = rtrim($filedName, $arr[$i]);
            }
            $query = "SELECT * FROM `{$tableName}` WHERE ({$filedName});";
            $result = $connection-> prepare($query);
            $result -> execute($data);
            $num = $result -> rowCount();
            try
            {
                if ($result)
                {
                    if ($num > 0)
                    {
                        return $result -> fetchAll(\PDO::FETCH_ASSOC);
                    }
                    return FALSE;
                }
                throw new \Exception($this -> sysMsg['serverError'][1]['msg1']);
            }
            catch (\Exception $error)
            {
                return $error -> getMessage();
            }


            // Flags Scope
            FETCH_ALL:
            {
                if (count($mathOp) > 0)
                {
                    //todo: create some query;
                }

                if (count($logicOp) > 0)
                {
                    $logicOp = implode(' ', $logicOp);
                    $query = "SELECT * FROM `{$tableName}` $logicOp;";
                    $result =  $connection -> prepare($query);
                    $result -> execute();
                }
                else
                {
                    $query = "SELECT * FROM `{$tableName}`;";
                    $result =  $connection -> prepare($query);
                    $result -> execute();
                }

                try
                {
                    if ($result)
                    {
                        return $result -> fetchAll(\PDO::FETCH_ASSOC);
                    }
                    throw new \Exception($this -> sysMsg['serverError'][1]['msg1']);
                }
                catch (\Exception $error)
                {
                    return $error ->getMessage();
                }
            }
        }


        public function insertProduct(array $arguments)
        {
            $connection = $this -> getConnection();
            $bind = [];
            $columns = [];
            $bindValues = [];
            $tableName = NULL;
            foreach ($arguments as $key => $value)
            {
                if ($key === 'tblName')
                {
                    $tableName = $arguments[$key];
                    unset($arguments[$key]);
                }
                if ($key === 0)
                {
                    $this -> primaryKey['id'] = $arguments[$key];
                }
            }

            if ($this -> primaryKey['id'] === 'NULL')
            {
                for ($i = 0; $i < count($arguments); $i++)
                {
                    $bind[] = '?';
                }
                $bind = implode(', ', $bind);

                $query = "INSERT INTO `{$tableName}` VALUES ({$bind});";
                $result = $connection -> prepare($query);
                $result -> execute($arguments);
                if ($result)
                {
                    return TRUE;
                }
                return FALSE;
            }
            else
            {
                unset($arguments[0]);
                $params = [];
                foreach ($arguments as $key => $value)
                {
                    switch ($key)
                    {
                        case 1:
                            $params['product_name'] = $arguments[$key];
                            break;
                        case 2:
                            $params['cat_id'] = $arguments[$key];
                            break;
                        case 3:
                            $params['available'] = $arguments[$key];
                            break;
                        case 4:
                            $params['price'] = $arguments[$key];
                            break;
                        case 5:
                            $params['color'] = $arguments[$key];
                            break;
                        case 6:
                            $params['short_text'] = $arguments[$key];
                            break;
                        case 7:
                            $params['description'] = $arguments[$key];
                            break;
                        case 8:
                            $params['pic'] = $arguments[$key];
                            break;
                    }
                }
//                for ($i = 0; $i < count($params); $i++)
//                {
//                    $bind[] = '?';
//                }
//                $bind = implode(', ', $bind);
                foreach ($params as $key => $value)
                {
                    $columns[$key] = $key;
                    $bindValues[$key] = $value;
                }
                $bindValues['id'] = $this -> primaryKey['id'];

                $columns = wrapData($columns, FALSE, TRUE);
                $columns = implode(', ', $columns);
                $columns = str_replace('.', ' = ', $columns);

                $query = "UPDATE `{$tableName}` SET {$columns}  WHERE (`id` = :id);";
                $result = $connection -> prepare($query);
                $result -> execute($bindValues);
                if ($result)
                {
                    return TRUE;
                }
                return FALSE;
            }
        }


        public function insert(array $arguments)
        {
            // todo: use try-catch to handle if $arguments is empty;

            $connection = $this -> getConnection();
            $this -> primaryKey['id'] = NULL;
            $values = [];
            $values_2 = [];
            $tableName = NULL;
            $allColumns = NULL;
            $fields = [];
            $bind = [];
            $mathOp = [];       // $mathOp:   array of math operator like  = , <> , != , ...
            $logicOp = [];      // $logicOp:  array of logical operators like  AND , OR , ...
            foreach ($arguments as $key => $value)
            {
                switch ($key)
                {
                    case 'id':
                        $arguments[$key] = strtoupper($arguments[$key]);
                        $this -> primaryKey['id'] = $arguments[$key];
                        break;
                    case 'values':
                        $values = $arguments[$key];
                        $values_2[$key] = $arguments[$key];
                        $values = $this -> primaryKey + $values;
                        for ($i = 0; $i < count($values); $i++)
                        {
                            $bind[] = '?';
                        }
//                        unset($bind[0]);
                        $bind = implode(', ', $bind);
                        break;
                    case 'tableName':
                        $tableName = $arguments[$key];
                        $tableName = $this -> tblPerfix.$tableName;
                        break;
                    case 'allColumns':
                        $allColumns = $arguments[$key];
                        break;
                    case 'fields':
                        $fields = $arguments[$key];
                        break;
                    case 'mathOp':
                        $mathOp = $arguments[$key];
                        break;
                    case 'logicOp':
                        $logicOp = $arguments[$key];
                        break;
                }
            }

            if ($this -> primaryKey['id'] === 'NULL')
            {
                // create right type array to bindValue in PDO
                $temp = [];
                foreach ($values as $value)
                {
                    $temp[] = $value;
                }
                $values = $temp;

                if ($allColumns === TRUE)
                {
//                    unset($values[0]);
                    $query = "INSERT INTO `{$tableName}` VALUES ($bind);";
                    $result = $connection -> prepare($query);
                    $result -> execute($values);
                    try
                    {
                        if ($result)
                        {
                            // todo: get last inserted item's id in to the file
//                            return $this -> sysMsg['serverSuccess'][1]['msg1'];
                            return TRUE;
                        }
                        throw new \Exception($this -> sysMsg['serverError'][1]['msg1']);
                    }
                    catch (\Exception $error)
                    {
                        return $error -> getMessage();
                    }
                }
                else
                {
                    //todo: set query if allColumns is not true;
                }
            }
            else
            {
                $temp = [];
                $bindValue = [];
                foreach ($values_2 as $data)
                {
                    foreach ($data as $key => $value)
                    {
                        $temp[] = '`'.$key.'`';
                    }
                }
                for ($i = 0; $i < count($mathOp); $i++)
                {
                    $temp[] = ' '.$mathOp[$i].' ';
                }
                for ($i = 0; $i < count($bind); $i++)
                {
                    $temp[] = $bind[$i];
                }
                $temp = implode($temp, '');
                foreach ($values as $value)
                {
                    $bindValue[] = $value;
                }

                $bindValue = array_reverse($bindValue);
                $query = "UPDATE `{$tableName}` SET $temp WHERE (`id` = ?);";
                $result = $connection -> prepare($query);
                $result -> execute($bindValue);
                try
                {
                    if ($result)
                    {
                        echo $this -> sysMsg['serverSuccess'][3]['msg3'];
                        return TRUE;
                    }
                    throw new \Exception($this -> sysMsg['serverError'][1]['msg1']);
                }
                catch (\Exception $error)
                {
                    return $error -> getMessage();
                }
            }
            return NULL;
        }


        public function delete($arguments)
        {
            // todo: use try-catch to handle if $arguments is empty;

            $connection = $this -> getConnection();
            $this -> primaryKey['id'] = NULL;
            $tableName = NULL;
            $conditions = [];
//            $bind = [];
            $filedName = [];
            $filedValue = [];
            $mathOp = [];       // $mathOp:   array of math operator like  = , <> , != , ...
            $logicOp = [];      // $logicOp:  array of logical operators like  AND , OR , ...

            foreach ($arguments as $key => $value)
            {
                switch ($key)
                {
                    case 'id':
                        $this -> primaryKey['id'] = intval($arguments[$key]);
                        break;
                    case 'conditions':
                        $conditions = $arguments[$key];
//                        $conditions = $this -> primaryKey + $conditions;
//                        for ($i = 0; $i < count($conditions); $i++)
//                        {
//                            $bind[] = '?';
//                        }
//                        $bind = implode(', ', $bind);
                        break;
                    case 'tableName':
                        $tableName = $arguments[$key];
                        $tableName = $this -> tblPerfix.$tableName;
                        break;
                    case 'mathOp':
                        $mathOp = $arguments[$key];
                        break;
                    case 'logicOp':
                        $logicOp = $arguments[$key];
                        break;
                }
            }


            foreach ($mathOp as $key => $value)
            {
                $mathOp[$key] = ' ' .$value. ' ';     // add space to begin and end of each index in $mathOp
            }

            foreach ($logicOp as $key => $value)
            {
                $logicOp[$key] = strtoupper(' ' .$value. ' ');    // change each elem in $logicOp to uppercase
            }

            foreach ($conditions as $fName => $val)
            {
                $filedName[] = $fName;
                $filedValue[$fName] = $val;
            }


            for ($i = 0; $i < count($filedName); $i++)      // these two loops is for making query string
            {
                if (isset($mathOp[$i]))
                {
                    $filedName[$i] = '`'.$filedName[$i].'`'.$mathOp[$i].':'.$filedName[$i];
                }
                else
                {
                    $filedName[$i] = '`'.$filedName[$i].'`'.$mathOp[$i - $i].':'.$filedName[$i];
                }
            }

            if (count($logicOp) !== 0)
            {
                for ($i = 0; $i < count($filedName); $i++)
                {
                    // todo: set condition when count of mathOp or logicOp is 0;

                    if (isset($logicOp[$i]))
                    {
                        $filedName[$i] = $filedName[$i].$logicOp[$i];
                    }
                    else
                    {
                        $filedName[$i] = $filedName[$i].$logicOp[$i - $i];
                    }
                }
            }

            $filedName = implode('', $filedName);
            $arr = [' AND ', ' OR ', ' NOT ', ' LIKE', 'ORDER BY '];
            for ($i = 0; $i < count($arr); $i++)
            {
                $filedName = rtrim($filedName, $arr[$i]);
            }
            $query = "DELETE FROM `{$tableName}` WHERE ({$filedName});";
            $result = $connection -> prepare($query);
            $result -> execute($conditions);
            try
            {
                if ($result)
                {
                    return TRUE;
                }
                else
                {
                    throw new \Exception($this -> sysMsg['serverError'][1]['msg1']);
                }
            }
            catch (\Exception $error)
            {
                return $error -> getMessage();
            }
        }

        public function __set($name, $value)
        {
            dump($name);
            dump($value);
        }


        public function __get($name)
        {
            dump($name);
        }


        public function __call($name, $arguments)
        {
            $this -> systemMessage();
            $class = get_class();
            try
            {
                if ($name === 'find')
                {
                    return call_user_func_array(array($class, 'select'), $arguments);
                }
                elseif (substr($name, 0, strlen('findBy')) === 'findBy')
                {
                    $funcName = 'findBy';
                    $args = ltrim($name, 'findBy');
                    dump($args);
//                    return call_user_func_array(array($class, 'findBy'), $arguments);
                }
                elseif (substr($name, 0, strlen('product')) === 'product')
                {
                    return call_user_func_array(array($class, 'insertProduct'), $arguments);
                }
                elseif (substr($name, 0, strlen('c_find')) === 'c_find')
                {
                    return call_user_func_array(array($class, 'complex'), $arguments);
                }
                else
                {
                    throw new \Exception($this -> sysMsg['serverError'][3]['msg3']);
                }
            }
            catch (\Exception $error)
            {
                return $error -> getMessage();
            }
        }


        public static function __callStatic($name, $arguments)
        {
            dump($name);
            dump($arguments);
        }
    }