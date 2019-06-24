<?php

/* * *********************************************************
 * ******** Core 
 * ******** V 1.1 - REV 8
 * stywill@gmail.com / w.oliveira@brandworks.com.br
 * ******************************************************* */

// DEV
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
date_default_timezone_set("America/Sao_Paulo");
setlocale(LC_ALL, 'pt_BR');

error_reporting(E_PARSE);
//import_request_variables("gP","");
extract($_GET, EXTR_REFS, "");
extract($_POST, EXTR_REFS, "");
extract($_REQUEST, EXTR_REFS, "");


$_core_run = "prod";

if ($_core_run == "prod") { //ambiente de produção
    $db_prefix = "_";
} else { //ambiente de teste
    $db_prefix = "_";
}

// ---------------------------------------------------------
class core {

    // CONFIG
    // ---------------------------------------------------------
    // setagens gerais para utilização / modificação rapida:
    public $_core_titulo = "BrandWorks";
    public $_core_run = "prod";
    public $db_prefix = "bwt_"; // prod
    public $data_ini = "2017-12-09"; // 
    //public $db_prefix = "hset_"; // teste
    public $_database_use = 'online';
    //public $_database_use = 'local';
    public $_filesys_use = 'local';
    public $_debug = false;
    public $_debug_visible = true; // abre a pagina com o debug aberto? se tiver false tem como abrir n precisa deixar aberto sempre
    // ---------------------------------------------------------
    // sist arquivos
    public $_filesys = array(
        'preview' => 'udata/preview/',
        'download' => 'udata/download/'
    );
    // ---------------------------------------------------------
    // database

    public $_database = array(
        'local' => array(
            'DB_HOST' => '127.0.0.1',
            'DB_USER' => 'root',
            'DB_PASS' => '',
            'DB_DATA' => 'gestao_pauta'
        ),
        'online' => array(
            'DB_HOST' => '186.202.152.62',
            'DB_USER' => 'bw_tabloides',
            'DB_PASS' => 'tab10Bw05',
            'DB_DATA' => 'bw_tabloides'
        ),
        'default' => array(
            'DB_HOST' => '',
            'DB_USER' => '',
            'DB_PASS' => '',
            'DB_DATA' => ''
        )
    );
    // ---------------------------------------------------------
    // sys geral
// -----------------------------------------------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------------------------
// NAO ALTERAR DAQUI PRA BAIXO
// -----------------------------------------------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------------------------
// -----------------------------------------------------------------------------------------------------------------------------

    public $_db = NULL;
    public $_vars = array(
        'core' => array(// modulo
            'modulo_id' => NULL, // id do modulo (tabela modulos)
            'modulo' => NULL, // nome do modulo 
            'axn_id' => NULL, // id da acao do modulo (modulos_acoes -> id_modulo | ['core']['modulo_id']
            'axn' => NULL, // nome da acao do modulo (modulos_acoes -> nome | ['core']['modulo_id']
            'permissao' => NULL, // sera setado false ou true apos verificação
            'include' => NULL   // include que o sistema ira puxar em loadContent
        ),
        'user' => array(// usuario
            'logado' => false, // usuario logado?
            'id' => NULL, // id
            'nome' => NULL, // nome
            'admin' => NULL, // é administrador? 1 ou 0 (buscar por if !$ / if $
            'ga' => NULL, // grupo de acesso (id tabela grupos_acessos)
            'regional' => NULL, // TTC - regional
            'cod_op' => NULL, // TTC - cod op
            'ng' => NULL, // TTC - num gerente
        ),
        'page' => array(// variaveis q sao passadas entre as paginas
            'mod' => NULL, // modulo - tabela modulos::nome
            'smod' => NULL, // submodulo (se aplicavel) - por enqto n utilizado
            'axn' => NULL, // acao - tabela modulos_acoes::nome
            'saxn' => NULL, // subacao (se aplicavel) - por enqto n utilizado
            'processa' => NULL, // solicita processamento (1 ou 0)
            'rto' => NULL, // return to 
            'msg_show' => false, // exibe msg (apenas p/ processa)
            'msg_cont' => NULL  // conteudo da msg (apenas p/ processa)
        ),
        'sys' => array(
            'msg' => NULL,
            'ev_passwd_length' => 4  //tamanho da senha de acesso de eventos (ambiente promotores)
        ),
        'session_prefix' => 'mia17'             //uso multiplo da core
    );
    public $_ui = array(
        'title' => '', // titulo começo página conteudo
        'menu' => '', // menu
        'header' => ''    // topo
    );
    public $_debug_container = array(
        'OUT' => '',
        'SQL' => '',
        'WRN' => '',
        'ERR' => '',
        'TIM' => ''
    );

    // FUNCOES SISTEMA
    // ---------------------------------------------------------
    // -------------------------------
    // debug
    private function dbg_in($type, $data) {
        $this->_debug_container[$type] .= "{" . date("Y-m-d H:i:s") . "} " . $data . "\r\n";
        switch ($type) {
            case 'OUT': $uf = "<font color=green><strong>OUT</strong></font>";
                break;
            case 'SQL': $uf = "<font color=blue><strong>SQL</strong></font>";
                break;
            case 'WRN': $uf = "<font color=orange><strong>WRN</strong></font>";
                break;
            case 'ERR': $uf = "<font color=red><strong>ERR</strong></font>";
                break;
            default: die('dbg_in TYPE invalido - enviado ' . $type);
                break;
        }
        $this->_debug_container['TIM'] .= $uf . " {" . date("Y-m-d H:i:s") . "} " . $data . "\r\n";
    }

    private function dbg_out() {
        if ($this->_debug_visible) {
            $dbsu = "block";
        } else {
            $dbsu = "none";
        }
        $dbstr = '<br><br><br><br><br><br><br><div align=center style="color:#ddd;"><a href="javascript:$(\'#debugbox\').toggle(\'fast\');">&nbsp;&nbsp;&nbsp;</a></div>'; //toggle no futuro entra aqui
        $dbstr .= '<div id="debugbox" name="debugbox" style="display:' . $dbsu . '; position: relative; left: 0px; width:98%; background-color:#FFF; border: 1px solid #F00; margin: 5px; padding: 5px;">';
        //
        $dbstr .= '<div align=center><strong>dbg</strong></div><br><pre>';
        $dbstr .= '<font color=green><strong>OUT</strong></font><br>' . htmlspecialchars(print_r($this->_debug_container['OUT'], true)) . '<br><br>';
        $dbstr .= '<font color=blue><strong>SQL</strong></font><br>' . htmlspecialchars(print_r($this->_debug_container['SQL'], true)) . '<br><br>';
        $dbstr .= '<font color=orange><strong>WRN</strong></font><br>' . htmlspecialchars(print_r($this->_debug_container['WRN'], true)) . '<br><br>';
        $dbstr .= '<font color=red><strong>ERR</strong></font><br>' . htmlspecialchars(print_r($this->_debug_container['ERR'], true)) . '<br><br><br>';
        $dbstr .= '<font color=black><strong>OrdemExec</strong></font><br>' . print_r($this->_debug_container['TIM'], true) . '<br><br><br>';
        $dbstr .= '<font color=black><strong>_vars</strong></font><br>' . print_r($this->_vars, true) . '<br><br><br>';
        $dbstr .= '</pre>';
        $dbstr .= '<hr size=80 color="#FF0000">';
        $dbstr .= '<pre>' . htmlspecialchars(print_r(get_defined_vars(), true)) . '</pre>';
        $dbstr .= '<hr size=80 color="#FF0000">';
        $dbstr .= '<pre>' . htmlspecialchars(print_r($_SERVER, true)) . '</pre></div>';
        $dbstr .= ''; // /toggle	
        return $dbstr;
    }

    // -------------------------------
    // construct/destruct

    public function __construct() {
        $this->dbg_in('OUT', __FUNCTION__);
        $this->database(1);
    }

    public function __destruct() {
        $this->dbg_in('OUT', __FUNCTION__);

        $this->database(0);

        if ($this->_debug) {
            echo $this->dbg_out();
        }

        unset($this->_core);
        unset($this->_debug_container);
        unset($this->_debug);
    }

    // versão PHP workaround de classes
    private function core() {
        if (version_compare(PHP_VERSION, "5.0.0", "<")) {
            $this->__construct();
            register_shutdown_function(array($this, "__destruct"));
        }
    }

    // ------------------------------------------------------------
    // historico 

    public function histread($type) {
        $action = $type[0];
        $tbname = $type[3];
        $cid = $type[4];

        $tbfields = array();

        $gettbf = mysqli_query($this->_db, "DESCRIBE " . $tbname);
        while ($row = mysqli_fetch_object($gettbf)) {
            array_push($tbfields, $row->Field);
        }
        unset($row);
        unset($gettbf);

        $tbfieldc = sizeof($tbfields);

        if ($action == "I") {
            $sqlcomm = "INSERT INTO " . $this->db_prefix . $tbname . " VALUES(NULL,";
            for ($c = 1; $c < $tbfieldc; $c++) {
                $sqlcomm .= "'" . $this->gsi($tbfields[$c], $this->db_prefix . $tbname, "id = '$cid'") . "'";
                if (($c + 1) == $tbfieldc) {
                    
                } else {
                    $sqlcomm .= ",";
                }
            }
            $sqlcomm .= ")";
        } elseif ($action == "U" || $action == "D") {
            $sqlcomm = "UPDATE " . $this->db_prefix . $tbname . " SET ";
            for ($c = 1; $c < $tbfieldc; $c++) {
                $sqlcomm .= $tbfields[$c] . " = '" . $this->gsi($tbfields[$c], $this->db_prefix . $tbname, "id = '$cid'") . "' ";
                if (($c + 1) == $tbfieldc) {
                    
                } else {
                    $sqlcomm .= ", ";
                }
            }
            $sqlcomm .= " WHERE (" . $tbfields[0] . " = '$cid')";
        }

        return $sqlcomm;
    }

    public function histwrite($type, $histr, $query) {
        $action = $type[0];
        $userid = $type[1];
        $modulo = $type[2];
        $tabela = $type[3];
        $id_id = $type[4];

        $modulo_id = $this->getIdModulo($modulo);

        //
        //INSERT INTO hist_index VALUES(NULL, id_modulo,tabela,id_id,id_usuario,action,now)
        if ($action == "I") {
            $histr = NULL;
        } else {
            $histr = mysqli_real_escape_string($this->_db, $histr);
        }

        $query = mysqli_real_escape_string($this->_db, $query);
        $id_id = mysqli_real_escape_string($this->_db, $id_id);

        mysqli_query($this->_db, "INSERT INTO " . $this->db_prefix . "hist_descr VALUES(NULL, '" . $modulo_id . "','" . $tabela . "','" . $id_id . "','" . $userid . "','" . $action . "','" . $query . "','" . $histr . "','" . $this->now() . "')");
        mysqli_query($this->_db, "INSERT INTO " . $this->db_prefix . "hist_index VALUES(NULL, '" . $modulo_id . "','" . $tabela . "','" . $id_id . "','" . $userid . "','" . $action . "','" . $this->now() . "')");

        if (mysqli_errno($this->_db)) {
            $this->dbg_in('ERR', 'FALHA HISTWRITE - (' . mysqli_errno($this->_db) . ') : ' . mysqli_error($this->_db) . print_r($type));
        } else {
            $this->dbg_in('SQL', __FUNCTION__ . ' CALLED - OK');
        }
    }

    // ------------------------------------------------------------
    // -------------------------------
    // DB

    public function query_type($type, $userid, $module, $table, $tableid) {
        $array = array($type, $userid, $module, $table, $tableid);
        //return $array;
    }

    private function database($action) {
        $this->dbg_in('OUT', __FUNCTION__);


        if ($action) {
            $this->_db = mysqli_connect($this->_database[$this->_database_use]['DB_HOST'], $this->_database[$this->_database_use]['DB_USER'], $this->_database[$this->_database_use]['DB_PASS'], $this->_database[$this->_database_use]['DB_DATA']);

            if (mysqli_connect_errno()) {
                $this->dbg_in('ERR', 'Falha conexao com SQL - (' . mysqli_connect_errno() . ') : ' . mysqli_connect_error());
            } else {
                $this->dbg_in('SQL', __FUNCTION__ . ' CONNECT');
            }
            // ajusta acentuação
            mysqli_set_charset($this->_db, 'utf8');
        } else {
            mysqli_close($this->_db);
            $this->dbg_in('SQL', __FUNCTION__ . ' CLOSE');
        }

        return 1;
    }

    public function gsi($item, $table, $where) {
        if ($where) {
            $where = "WHERE " . $where;
        } else {
            $where = "";
        }
        $getc = mysqli_query($this->_db, "SELECT " . $item . " FROM " . $table . " " . $where);
        $rr = mysqli_fetch_object($getc);
        $itemres = $rr->$item;
        $debug = "|" . $item . "|" . $table . "|" . $where;
        if (mysqli_errno($this->_db)) {
            $this->dbg_in('ERR', 'FALHA GSI - (' . mysqli_errno($this->_db) . ') : ' . mysqli_error($this->_db) . ' -- PARAMS: ' . $debug);
        }
        unset($rr);
        mysqli_free_result($getc);

        return $itemres;
    }

    public function gsi2($item, $table, $where) {
        if ($where) {
            $where = "WHERE " . $where;
        } else {
            $where = "";
        }
        $item = (!$item) ? "*" : $item;
        return "SELECT " . $item . " FROM " . $this->db_prefix . $table . " " . $where;
    }

    public function gsim($item, $table, $where) {
        if ($where) {
            $where = " WHERE " . $where;
        } else {
            $where = "";
        }
        if ($item) {
            $apelido = explode('|', $item);
            $item = ($apelido[1]) ? $apelido[0] . "'" . $apelido[1] . "'" : $item;
        } else {
            $item = "*";
        }
        $gett = $this->sql(NULL, "SELECT " . $item . " FROM " . $this->db_prefix . $table . $where);
        while ($row = mysqli_fetch_object($gett)) {
            $linha[] = $row;
        }
        return $linha;
    }

    public function updateNotif($cid, $col) {
        $querytype = $this->query_type("U", $this->_vars['user']['id'], $this->_vars['page']['mod'], $this->db_prefix . 'notif', $cid);
        $query = "UPDATE " . $this->db_prefix . "notif SET $col=$col-1 WHERE (id = '$cid')";
        $run = $this->sql($querytype, $query);
        return $run;
    }

    public function gsic($item, $table, $where) {
        if ($where) {
            $where = "WHERE " . $where;
        } else {
            $where = "";
        }
        $getc = mysqli_query($this->_db, "SELECT " . $item . " FROM " . $table . " " . $where);
        $rr = mysqli_fetch_object($getc);
        $itemres = $rr->$item;
        $debug = "|" . $item . "|" . $table . "|" . $where;
        if (mysqli_errno($this->_db)) {
            $this->dbg_in('ERR', 'FALHA GSI - (' . mysqli_errno($this->_db) . ') : ' . mysqli_error($this->_db) . ' -- PARAMS: ' . $debug);
        }
        unset($rr);
        mysqli_free_result($getc);

        if (!$itemres) {
            $itemres = 0;
        }
        return $itemres;
    }

    // Construtor de select para consultas em base de daddos 
    public function selectClass($name, $id, $class, $onchange, $item, $concat, $table, $where, $ordem, $selected, $opcao) {
        $opcao = (!$opcao) ? 'Selecione uma opção' : $opcao;
        if ($name == "status" && $table == "") {
            $select = ' <select name="status" id="status" class="' . $class . '"  onchange="' . $onchange . '">';
            if (!$selected || $selected == "ATIVO")
                $se = "selected";
            else
                $se = "";
            $select .= '	<option value="A" ' . $se . '>ATIVO</option>';
            if ($selected == "I")
                $se = "selected";
            else
                $se = "";
            $select .= '	<option value="I" ' . $se . '>INATIVO</option>';
            $select .= '</select>';
        }else {
            $col = explode(",", $item);
            if ($col[0] == "concat") {
                $item = "concat(" . $col[1] . ",'" . $concat . "'," . $col[2] . ")," . $col[1] . "," . $col[2];
                $col[0] = $col[1] . $concat . $col[2];
                $flag = true;
            }
            $sql = "select " . $item . " from " . $this->db_prefix . $table;
            if ($where) {
                $sql .= " where " . $where;
            }
            if ($ordem) {
                $sql .= " order by " . $ordem;
            }

            $var0 = $col[0];
            $var1 = $col[1];
            $var2 = $col[2];

            $query = $this->sql(NULL, $sql);
            $select = '<select name="' . $name . '" id="' . $id . '" class="' . $class . '" onChange="' . $onchange . '" >';
            $select .= "<option value=''>" . $opcao . "</option>";
            while ($row = mysqli_fetch_object($query)) {
                if ($concat) {
                    $desc = $row->$var1 . $concat . $row->$var2;
                } else {
                    $desc = $row->$var1;
                }
                $apl = explode('.', $col[0]);
                $colu = ($apl[1]) ? $apl[1] : $col[0];
                $value = ($flag) ? $desc : $row->$var0;
                $select .= "<option value='" . $value . "' title='" . $desc . "'";
                $select .= ($selected == $value) ? " selected" : "";
                $select .= ">&nbsp;" . $desc . "</option>";
            }
            $select .= '</select>';
        }
        return $select;
    }

    public function selectClass2($name, $id, $class, $onchange, $item, $concat, $table, $where, $ordem, $selected) {
        $sql = "select " . $item . " from " . $this->db_prefix . $table;
        if ($where) {
            $sql .= " where " . $where;
        }
        if ($ordem) {
            $sql .= " order by " . $ordem;
        }
        return $sql;
    }

    // recupera uma array de linhas unicas, com um item, mais separados por pipe...
    public function gArUnique($item, $table, $where, $fieldID = NULL) {
        if ($where) {
            $where = "WHERE " . $where;
        } else {
            $where = "";
        }
        $getc = mysqli_query($this->_db, "SELECT DISTINCT " . ($fieldID ? "$fieldID, " : '') . $item . " FROM " . $table . " " . $where);
        //echo("SELECT DISTINCT ".($fieldID?"$fieldID, ":'').$item." FROM ".$table." ".$where."<br>"); //DEBUG
        $retorno = array();
        while ($rr = mysqli_fetch_array($getc, MYSQL_ASSOC)) {
            if ($fieldID) {
                $id = $rr[$fieldID];
                unset($rr["$fieldID"]);
                $retorno[$id] = trim(implode("|", $rr), '|');
            } else
                $retorno[] = trim(implode("|", $rr), '|');
        }

        $debug = "|" . $item . "|" . $table . "|" . $where;
        if (mysqli_errno($this->_db)) {
            $this->dbg_in('ERR', 'FALHA GSI - (' . mysqli_errno($this->_db) . ') : ' . mysqli_error($this->_db) . ' -- PARAMS: ' . $debug);
        }
        unset($rr);
        mysqli_free_result($getc);

        return $retorno;
    }

    // !usar query_type sempre antes de chamar essa fn
    // se for INSERT retorna insert_id
    // se for update, retorna affected_rows
    public function sql($type, $query) {
        if (!$type) { // LEITURA / SELECT - retorna query pronta para fetch
            $getq = mysqli_query($this->_db, $query);
            if (mysqli_errno($this->_db)) {
                $this->dbg_in('ERR', 'FALHA SQL - (' . mysqli_errno($this->_db) . ') : ' . mysqli_error($this->_db) . ' -- QUERY: {' . $query . '}');
            }
            return $getq;
        } else { // ESCRITA
            $histr = $this->histread($type);

            if ($type[0] == "I") {
                mysqli_query($this->_db, $query) or die(mysqli_errno($this->_db) . ' : ' . mysqli_error($this->_db) . ' -- ' . $query);
                $use_return = mysqli_insert_id($this->_db);
            } elseif ($type[0] == "U" || $type[0] == "D") {
                mysqli_query($this->_db, $query) or die(mysqli_errno($this->_db) . ' : ' . mysqli_error($this->_db) . ' -- ' . $query);
                $use_return = mysqli_affected_rows($this->_db);
            } elseif ($type[0] == "R") { //delete efetivo, provavelmente n sera usado
            }

            $this->histwrite($type, $histr, $query);

            if (mysqli_errno($this->_db)) {
                $this->dbg_in('ERR', 'FALHA SQL - (' . mysqli_errno($this->_db) . ') : ' . mysqli_error($this->_db) . ' -- TYPE: ' . print_r($type) . ' -- QUERY: {' . $query . '}');
            } else {
                $this->dbg_in('SQL', __FUNCTION__ . ' OK - Type:' . $type[0] . ' retornou ' . $use_return . ' {' . $query . '}');
                return $use_return;
            }
        }
    }

    public function gsicount($item, $table, $where) {
        $var = "<p><strong>" . $this->gsi("count(" . $item . ")", $table, $where) . "</strong> registro(s) encontrado(s).</p>";
        return $var;
    }

    //apenas printa o rowCount sem GSI
    public function printRowCount($num) {
        $var = "<p><strong>" . $num . "</strong> registro(s) encontrado(s).</p>";
        return $var;
    }

    // -------------------------------
    // ---------------------------------------------------------	// ---------------------------------------------------------
    // ---------------------------------------------------------	// ---------------------------------------------------------
    // USUARIOS
    // ---------------------------------------------------------
    // ---------------------------------------------------------	// ---------------------------------------------------------
    // ---------------------------------------------------------	// ---------------------------------------------------------
    // GR ACESS
    // ---------------------------------------------------------


    public function verificaPermissao($grpid, $modid, $axnid) {
        if ($this->_vars['user']['admin']) {
            return 1;
        } else {
            $isModSys = $this->gsi("ordem", $this->db_prefix . "modulos", "(id = '$modid')");
            if ($isModSys < 0) {
                return 1;
            } else {

                //$getmap = $this->gsi("permissao",$this->db_prefix."ga_permissoes","(id_grupo = '$grpid' AND id_modulo = '$modid' AND id_acao = '$axnid')");
                $getmap = $this->gsi("permissao", $this->db_prefix . "ga_permissoes", "(id_grupo = '$grpid' AND id_modulo = '$modid' AND id_acao = '0')");
            }
            return $getmap;
        }
    }

    // ---------------------------------------------------------	// ---------------------------------------------------------
    // ---------------------------------------------------------	// ---------------------------------------------------------
    // ACESSO / AUTH
    // ---------------------------------------------------------
    public function auth() {
        global $_POST, $_SESSION;

        $tryuid = $this->gsi("id", $this->db_prefix . "usuarios", "(login = '" . $_POST['login'] . "' AND senha = '" . $_POST['senha'] . "' AND id_grupo <> 10 AND status = 'A')");
        if (!$tryuid) { //erro de login
            return -1;
        } else {
            $username = $this->gsi("nome", $this->db_prefix . "usuarios", "(id = '$tryuid')");
            $area = $this->gsi("area", $this->db_prefix . "usuarios", "(id = '$tryuid')");
            $user_ga = $this->gsi("id_grupo", $this->db_prefix . "usuarios", "(id = '$tryuid')");
            $user_email = $this->gsi("email", $this->db_prefix . "usuarios", "(id = '$tryuid')");
            $user_admin = $this->gsi("administrador", $this->db_prefix . "grupos_acessos", "(id = '$user_ga')");
            $user_idgeo = $this->gsi("id_estado_geo", $this->db_prefix . "usuarios", "(id = '$tryuid')");
            $user_geo = $this->gsi("geo", $this->db_prefix . "usuarios u, ".$this->db_prefix ."aux_estados e", "(e.id = u.id_estado_geo AND u.id = '$tryuid')");
            $acessos = $this->gsi("total_acessos", $this->db_prefix . "usuarios", "(id = '$tryuid')");

            $nacessos = $acessos + 1;
            mysqli_query($this->_db, "UPDATE " . $this->db_prefix . "usuarios SET data_ultimo_acesso = '" . $this->now() . "', total_acessos = '" . $nacessos . "' WHERE (id = '" . $tryuid . "') ");



            $_SESSION[$this->_vars['session_prefix']]['sess_uid'] = $tryuid;
            $_SESSION[$this->_vars['session_prefix']]['sess_nome'] = $username;
            $_SESSION[$this->_vars['session_prefix']]['sess_area'] = $area;
            $_SESSION[$this->_vars['session_prefix']]['sess_email'] = $user_email;
            $_SESSION[$this->_vars['session_prefix']]['sess_admin'] = $user_admin;
            $_SESSION[$this->_vars['session_prefix']]['sess_id_geo'] = $user_idgeo;
            $_SESSION[$this->_vars['session_prefix']]['sess_geo'] = $user_geo;
            $_SESSION[$this->_vars['session_prefix']]['sess_ga'] = $user_ga;

            // TTC gerentes
            $_SESSION[$this->_vars['session_prefix']]['sess_regional'] = $_POST['regional'];
            $_SESSION[$this->_vars['session_prefix']]['sess_cod_op'] = $_POST['cod_op'];
            $_SESSION[$this->_vars['session_prefix']]['sess_ng'] = $_POST['num_gerente'];

            if ($nacessos == 1) {
                return 0;
            } else {
                return 1;
            }

            //return $nacessos;
        }
    }

    public function verifica_auth() {
        global $_SESSION;
        $check_sess = $_SESSION[$this->_vars['session_prefix']]['sess_uid'];
        if ($check_sess) {
            $this->_vars['user']['logado'] = true;
            $this->_vars['user']['id'] = $_SESSION[$this->_vars['session_prefix']]['sess_uid'];
            $this->_vars['user']['nome'] = $_SESSION[$this->_vars['session_prefix']]['sess_nome'];
            $this->_vars['user']['area'] = $_SESSION[$this->_vars['session_prefix']]['sess_area'];
            $this->_vars['user']['email'] = $_SESSION[$this->_vars['session_prefix']]['sess_email'];
            $this->_vars['user']['admin'] = $_SESSION[$this->_vars['session_prefix']]['sess_admin'];
            $this->_vars['user']['idgeo'] = $_SESSION[$this->_vars['session_prefix']]['sess_id_geo'];
            $this->_vars['user']['usgeo'] = $_SESSION[$this->_vars['session_prefix']]['sess_geo'];
            $this->_vars['user']['ga'] = $_SESSION[$this->_vars['session_prefix']]['sess_ga'];
            $this->_vars['user']['regional'] = $_SESSION[$this->_vars['session_prefix']]['sess_regional'];
            $this->_vars['user']['cod_op'] = $_SESSION[$this->_vars['session_prefix']]['sess_cod_op'];
            $this->_vars['user']['ng'] = $_SESSION[$this->_vars['session_prefix']]['sess_ng'];
            $this->dbg_in('OUT', __FUNCTION__ . ' OK');
           // dicionario_views::viewOperacoesEstados();
        } else {
            $this->_vars['user']['logado'] = false;
            $this->_vars['user']['id'] = NULL;
            $this->_vars['user']['nome'] = NULL;
            $this->_vars['user']['area'] = NULL;
            $this->_vars['user']['email'] = NULL;
            $this->_vars['user']['admin'] = NULL;
            $this->_vars['user']['usgeo'] = NULL;
            $this->_vars['user']['ga'] = NULL;
            $this->_vars['user']['cod_op'] = NULL;
            $this->_vars['user']['regional'] = NULL;
            $this->_vars['user']['ng'] = NULL;
            $this->dbg_in('OUT', __FUNCTION__ . ' FAIL');
        }
    }

    public function isadmin() {
        if ($this->_vars['user']['admin']) {
            return 1;
        } else {
            return 0;
        }
    }

    //log
    public function grava_acesso() {
        //grava log acesso
    }

    // MODULOS - SEC
    // ---------------------------------------------------------
    // ---------------------------------------------------------	// ---------------------------------------------------------
    // ---------------------------------------------------------	// ---------------------------------------------------------
    // MODULOS - GERAL
    // ---------------------------------------------------------
    public function buildModLink($mod, $axn, $params) {

        if (is_numeric($mod)) {
            $modid = $mod;
            $modnm = $this->getNomeModulo($modid);
        } else {
            $modnm = $mod;
            $modid = $this->getIdModulo($modnm);
        }

        if (!$axn) {
            $axnnm = 'default';
            $axnid = $this->getIdModuloAcao($modid, $axnnm);
        } else {
            if (is_numeric($axn)) {
                $axnid = $axn;
                $axnnm = $this->getNomeModuloAcao($modid, $axn);
            } else {
                $axnnm = $axn;
                $axnid = $this->getIdModuloAcao($modid, $axnnm);
            }
        }

        $link = "sistema.php?mod=" . $modnm . "&ver=" . $axnnm . $params;

        return $link;
    }

    public function buildFormAction($mod) {

        if (is_numeric($mod)) {
            $modid = $mod;
            $modnm = $this->getNomeModulo($mod);
        } else {
            $modnm = $mod;
            $modid = $this->getIdModulo($mod);
        }

        $str = $this->gsi("filep", $this->db_prefix . "modulos", "(id = '$modid')");
        if (!$str) {
            $str = "processa.php";
        }

        $fc = 0;
        while (list($key, $value) = each($this->_vars['page'])) {
            if ($fc == 0) {
                $str .= "?";
            } else {
                $str .= "&";
            }
            $str .= $key . '=' . $value;
            $fc++;
        }

        return $str;
    }

    public function getIdModulo($modulo) {
        $trym = $this->gsi("id", $this->db_prefix . "modulos", "(nome = '$modulo')");
        if (!$trym) {
            $this->dbg_in('WRN', __FUNCTION__ . ' MODULO NAO ENCONTRADO: ' . $modulo);
        } else {
            return $trym;
        }
    }

    //DC 2016
    public function getStModulo($modid) {
        $trym = $this->gsi("status", $this->db_prefix . "modulos", "(id = '$modid')");
        if (!$trym) {
            $this->dbg_in('WRN', __FUNCTION__ . ' MODULO NAO ENCONTRADO: ' . $modulo);
        } else {
            if ($trym == 'A') {
                return 1;
            } else {
                return 0;
            }
        }
    }

    public function getNomeModulo($modid) {
        $trym = $this->gsi("nome", $this->db_prefix . "modulos", "(id = '$modid')");
        if (!$trym) {
            $this->dbg_in('WRN', __FUNCTION__ . ' MODULO NAO ENCONTRADO: ' . $modulo);
        } else {
            return $trym;
        }
    }

    public function getIdModuloAcao($modulo, $axn) {

        if (is_numeric($modulo)) { // id modulo
            $mod = $modulo;
        } else {
            $mod = $this->getIdModulo($modulo);
        }

        if (!$axn) {
            $axn = "default";
        }

        $trym = $this->gsi("id", $this->db_prefix . "modulos_acoes", "(id_modulo = '$mod' AND acao = '$axn')");
        if (!$trym) {
            $this->dbg_in('WRN', __FUNCTION__ . ' ACAO MODULO NAO ENCONTRADO: ' . $modulo . ' -- ' . $axn);
        } else {
            return $trym;
        }
    }

    public function getNomeModuloAcao($modulo, $axn) {

        if (is_numeric($modulo)) { // id modulo
            $mod = $modulo;
        } else {
            $mod = $this->getIdModulo($modulo);
        }

        if (!$axn) {
            $trym = "default";
        } else {
            $trym = $this->gsi("acao", $this->db_prefix . "modulos_acoes", "(id_modulo = '$mod' AND id = '$axn')");
        }

        if (!$trym) {
            $this->dbg_in('WRN', __FUNCTION__ . ' ACAO MODULO NAO ENCONTRADO: ' . $modulo . ' -- ' . $axn);
        } else {
            return $trym;
        }
    }

    public function getInclude($modid, $axnid, $processa) {
        if ($processa) {
            $sqla = "filep";
        } else {
            $sqla = "file";
        }

        $tryaxi = $this->gsi($sqla, $this->db_prefix . "modulos_acoes", "(id_modulo = '" . $modid . "' AND id = '" . $axnid . "')");
        if ($tryaxi) { // use acao specific
            $useinc = $tryaxi;
        } else { // use modulo
            $useinc = $this->gsi($sqla, $this->db_prefix . "modulos", "(id = '" . $modid . "')");
        }
        return $useinc;
    }

    private function setModule($modulo, $axn, $processa) {

        if (is_numeric($modulo)) { // id modulo
            $modid = $modulo;
            $modnm = $this->getNomeModulo($modulo);
        } else {
            $modid = $this->getIdModulo($modulo);
            $modnm = $modulo;
        }

        if (!$axn) {
            $axnid = $this->getIdModuloAcao($modid, 'default');
            $axnnm = 'default';
        } else {

            if (is_numeric($axn)) { // id axn
                $axnid = $axn;
                $axnnm = $this->getNomeModuloAcao($modid, $axn);
            } else {
                $axnid = $this->getIdModuloAcao($modid, $axn);
                $axnnm = $axn;
            }
        }


        $this->_vars['core']['modulo'] = $modnm;
        $this->_vars['core']['modulo_id'] = $modid;
        $this->_vars['core']['axn_id'] = $axnid;
        $this->_vars['core']['axn'] = $axnnm;
        $this->_vars['core']['include'] = $this->getInclude($modid, $axnid, $processa);

        // [ ] fix SEC sys
        if ($this->_vars['core']['modulo'] == 'login' || $this->_vars['core']['modulo'] == 'home') {
            $this->_vars['core']['permissao'] = 1;
        } else {
            $this->_vars['core']['permissao'] = $this->verificaPermissao($this->_vars['user']['ga'], $modid, $axnid);
        }

        if (!$this->_vars['core']['permissao']) {
            $this->_vars['sys']['msg'] = "Voc&ecirc; n&atilde;o possui permiss&atilde;o para realizar esta a&ccedil;&atilde;o.";
        }

        $this->_ui['title'] = "<h1>" . ucwords($this->gsi("descricao", $this->db_prefix . "modulos", "(id = '" . $this->_vars['core']['modulo_id'] . "')")) . "</h1>";


        return 1;
    }

    // UI
    // ---------------------------------------------------------
    public function buildMenu() {
        /*
          <div class="menuBtn"><a href="#">Página Principal</a></div>
          <div class="menuBtn"><a href="#">Botão 01</a></div>
         */
        $ms = '<div class="menuBtn">';
        $me = '</div>';


        $str = "";
        if (!$this->_vars['user']['logado']) {
            $str = $ms . "<a href=\"index.php\">Login</a>" . $me;
        } else {
            //..	
            // [ ] GA
            if ($this->_vars['user']['admin']) {
                $listMod = $this->sql(NULL, "select id,descricao from " . $this->db_prefix . "modulos WHERE (status = 'A' AND ordem >= 0) ORDER BY ordem,id ");
            } else {
                // GA err
                //$listMod = $this->sql(NULL,"select id,descricao from ".$this->db_prefix."modulos WHERE (status = 'A' AND ordem >= 0) ORDER BY ordem,id ");
                $listMod = $this->sql(NULL, "select m.id,m.descricao,ga.permissao from " . $this->db_prefix . "modulos m LEFT JOIN " . $this->db_prefix . "ga_permissoes ga ON ga.id_modulo = m.id WHERE (m.status = 'A' AND m.ordem >= 0 AND ga.id_grupo = '" . $this->_vars['user']['ga'] . "' AND ga.id_acao = 0 AND ga.permissao = '1' ) ORDER BY m.ordem,m.id ");

                $str .= $ms . "<a href='" . $this->buildModLink(1, NULL, NULL) . "'>" . ucwords("Home") . "</a>" . $me;
            }

            while ($row = mysqli_fetch_object($listMod)) {
                $str .= $ms . "<a href='" . $this->buildModLink($row->id, NULL, NULL) . "'>" . ucwords($row->descricao) . "</a>" . $me;
            }
        }

        return $str;
    }

    public function buildHeader() {

        $str = '';

        if (!$this->_vars['user']['logado']) {
            $str = '';
        } else {
            $str = '
		<div id="menuConfigBtns">
			<p><strong>Olá, ' . $this->_vars['user']['nome'] . '</strong></p>
			<a href="index.php?mod=config">Configurações</a> | <a href="sair.php">Logout</a>
		</div>';
        }
        return $str;
    }

    public function showSysMsg() {
        return "<p align=center><strong>" . $this->_vars['sys']['msg'] . "</strong><br><br><a href='javascript:history.back();'>voltar</a></p>";
    }

    // ---------------------------------------------------------	// ---------------------------------------------------------
    // ---------------------------------------------------------	// ---------------------------------------------------------
    // ---------------------------------------------------------	// ---------------------------------------------------------
    // ---------------------------------------------------------	// ---------------------------------------------------------
    // 8 - FUNCOES CORE / AUXs
    // ---------------------------------------------------------
    public function write($string, $status) {
        if ($status == 'I') {
            $str = "<font color=red>" . $string . "</font>";
        } else {
            $str = $string;
        }
        return $str;
    }

    public function cllv($str) {
        $strl = strlen($str);
        $nstr = substr($str, 0, ($strl - 1));
        return $nstr;
    }

    public function priNome($srt) {
        $primeiro = explode(" ", $srt);
        return $primeiro[0];
    }

    public function exibedata($data) {
        if ($data == "0000-00-00" || $data == "") {
            $newdata = "";
        } else {
            $ndata = explode(" ", $data);
            $ndata = explode("-", $ndata[0]);

            $newdata = $ndata[2] . "/" . $ndata[1] . "/" . $ndata[0];
            return $newdata;
        }
    }

    public function exibedata_us($data) {
        if ($data == "0000-00-00" || $data == "" || $data == "00/00/0000") {
            $newdata = "";
        } else {
            $ndata = explode(" ", $data);
            $ndata = explode("-", $ndata[0]);

            $newdata = $ndata[1] . "/" . $ndata[2] . "/" . $ndata[0];
            if ($newdata == "00/00/0000") {
                $newdata = "";
            }
            return $newdata;
        }
    }

    public function exibedatah($data) {
        if ($data == "0000-00-00 00:00:00" || $data == "") {
            $newdata = "";
        } else {
            $xdata = explode(" ", $data);
            $ndata = explode("-", $xdata[0]);

            $newdata = $ndata[2] . "/" . $ndata[1] . "/" . $ndata[0] . " - " . $xdata[1];
            return $newdata;
        }
    }

    public function gravadata($data) {
        if ($data == "00/00/0000" || $data == "") {
            $newdata = "";
        } else {
            $ndata = explode("/", $data);

            $newdata = $ndata[2] . "-" . $ndata[1] . "-" . $ndata[0];
            return $newdata;
        }
    }

    public function gravadata_us($data) {
        if ($data == "00/00/0000" || $data == "") {
            $newdata = "";
        } else {
            $ndata = explode("/", $data);

            $newdata = $ndata[2] . "-" . $ndata[0] . "-" . $ndata[1];
            return $newdata;
        }
    }

    public function diffDate($d1, $d2) {
        $d2 = ($d2) ? $d2 : date('Y-m-d');
        $diferenca = strtotime($d1) - strtotime($d2);

        //Calcula a diferença em dias
        $dias = floor($diferenca / (60 * 60 * 24));

        return $dias;
    }

    public function diffTime($h1, $h2) {
        $h1e = explode(":", $h1);
        $h2e = explode(":", $h2);

        $d = date("d");
        $m = date("m");
        $y = date("Y");

        $timestamp1 = mktime($h1e[0], $h1e[1], $h1e[2], $d, $m, $y);
        $timestamp2 = mktime($h2e[0], $h2e[1], $h2e[2], $d, $m, $y);

        $df_s = $timestamp2 - $timestamp1;

        return gmdate("H:i:s", $df_s);
    }

    function now() {
        return date("Y-m-d H:i:s");
    }

    function fixcurr($val, $type) {
        if ($type == "W") {
            $nval = str_replace("R\$ ", "", $val);
            $nval = str_replace("_", "", $nval);
            $nval = str_replace(".", "", $nval);
            $nval = str_replace(",", ".", $nval);
            $nval = (float) $nval;
        } elseif ($type == "R") {
            $nval = number_format($nval, 2, ",", ".");
            $nval = str_replace(".", ",", $val);

            $nval = "R\$ " . $nval;
        }
        return $nval;
    }

    // ---------------------------------------------------------
    // 05/2014 - adicionado estrutura pra gerar senha automatica dos eventos

    public function gera_ev_passwd() {

        $code_length = $this->_vars['sys']['ev_passwd_length'];

        $code = md5(uniqid(mt_rand(), true));
        $code = substr($code, 0, $code_length);
        $code = strtoupper($code);

        $trycode = $this->gsi("count(1)", $this->db_prefix . "eventos", "(senha = '$code')");
        if ($trycode) {
            $code = md5(uniqid(mt_rand(), true));
            $code = substr($code, 0, $code_length);
            $code = strtoupper($code);

            $trycode = $this->gsi("count(1)", $this->db_prefix . "eventos", "(senha = '$code')");
            if ($trycode) {
                $code = md5(uniqid(mt_rand(), true));
                $code = substr($code, 0, $code_length);
                $code = strtoupper($code);
            }
        }

        return $code;
    }

    public function fix_mysql_str($str) {

        $tmp_str = $str;
        $tmp_str = str_replace('\\', '', $tmp_str);
        $tmp_str = str_replace('\"', '"', $tmp_str);
        $tmp_str = str_replace("\'", "'", $tmp_str);

        $tmp_str = str_replace('"', '&quot;', $tmp_str);

        $final_str = htmlspecialchars($tmp_str, ENT_COMPAT);
        $final_str = mysqli_real_escape_string($this->_db, $tmp_str);

        return $final_str;
    }

    public function sanitizeString($string) {
        // matriz de entrada
        $what = array('ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û', 'À', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ç', 'Ç', ' ', '-', '(', ')', ',', ';', ':', '|', '!', '"', '#', '$', '%', '&', '/', '=', '?', '~', '^', '>', '<', 'ª', 'º');

        // matriz de saída
        $by = array('a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'A', 'A', 'E', 'I', 'O', 'U', 'n', 'n', 'c', 'C', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_');

        // devolver a string
        return str_replace($what, $by, $string);
    }

    // L - EXEC
    // ---------------------------------------------------------
    // carrega estrutura geral

    public function load() {
        global $_SESSION, $_REQUEST;
        $this->dbg_in('OUT', __FUNCTION__ . ' START');

        //seta autenticacao do user
        $this->verifica_auth();

        // 1 - seta variaveis da pagina na classe
        $this->_vars['page']['mod'] = $_REQUEST['mod'];
        $this->_vars['page']['smod'] = $_REQUEST['smod'];
        $this->_vars['page']['axn'] = $_REQUEST['axn'];
        $this->_vars['page']['saxn'] = $_REQUEST['saxn'];
        $this->_vars['page']['processa'] = $_REQUEST['processa'];
        $this->_vars['page']['rto'] = $_REQUEST['rto'];
        $this->_vars['page']['msg_show'] = $_REQUEST['msg_show'];
        $this->_vars['page']['msg_cont'] = $_REQUEST['msg_cont'];


        // 2 - inicia verificação
        // 2A - foi informado um módulo?
        if (!$this->_vars['page']['mod']) {
            if ($this->_vars['user']['id']) { // home
                $this->setModule('home', NULL, '0');
            } else { // login
                //$this->setModule('login',NULL,'0');
                header("Location: index.php");
            }
        } else {

            $this->setModule($this->_vars['page']['mod'], $this->_vars['page']['axn'], $this->_vars['page']['processa']);
        }

        // seta estrutura de UI


        $this->_ui['menu'] = $this->buildMenu();
        $this->_ui['header'] = $this->buildHeader();


        $this->dbg_in('OUT', __FUNCTION__ . ' END');

        return 1;
    }

    public function loadContent() {
        $this->dbg_in('OUT', __FUNCTION__ . ' - load:' . $this->_vars['core']['include']);
    }

    // ---------------------------------------------------------	// ---------------------------------------------------------
    // ---------------------------------------------------------	// ---------------------------------------------------------
    // REV 7 - funções próprias para jqUI

    public function drawMsg($msg) {

        $val = '<div class="ui-widget">
		<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
			<p><span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>
			' . $msg . '</p>
		</div>
	</div>';

        return $val;
    }

    public function drawAlert($msg) {

        $val = '<div class="ui-widget">
	<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
		<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
		' . $msg . '</p>
	</div>
</div>';

        return $val;
    }

    /* ----------UPLOAD DE IMAGEN----------------------------- */
    /* ------------------------------------------------------- */

    public function imgUpload($imagem, $caminho, $largura, $altura, $tamanho, $cid) {
        // Largura máxima em pixels 
        //$largura = 150;
        // Altura máxima em pixels 
        //$altura = 180; 
        // Tamanho máximo do arquivo em bytes 
        //$tamanho = 1000;   
        // Verifica se o arquivo é uma imagem 
        if ($cid) {
            $gete = $this->sql(NULL, "select imagem_ori from " . $db_prefix . "fornecedores WHERE (id = '" . $cid . "') ");
            $red = mysqli_fetch_object($gete);
            unlink($caminho . $red->imagem_ori . "");
        }
        if (!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $imagem["type"])) {
            $error[1] = "Isso não é uma imagem.";
        }
        // Pega as dimensões da imagem 
        $dimensoes = getimagesize($imagem["tmp_name"]);
        // Verifica se a largura da imagem é maior que a largura permitida 
        if ($dimensoes[0] > $largura) {
            $error[2] = "A largura da imagem não deve ultrapassar " . $largura . " pixels";
        }
        // Verifica se a altura da imagem é maior que a altura permitida 
        if ($dimensoes[1] > $altura) {
            $error[3] = "Altura da imagem não deve ultrapassar " . $altura . " pixels";
        }
        // Verifica se o tamanho da imagem é maior que o tamanho permitido 
        if ($imagem["size"] > $tamanho) {
            $error[4] = "A imagem deve ter no máximo " . $tamanho . " bytes";
        }
        // Se não houver nenhum erro 
        if (count($error) == 0) {
            // Pega extensão da imagem 
            preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $imagem["name"], $ext);
            // Gera um nome único para a imagem 
            $nome_imagem = md5(uniqid(time())) . "." . $ext[1];
            // Caminho de onde ficará a imagem 
            $caminho_imagem = $caminho . $nome_imagem;
            // Faz o upload da imagem para seu respectivo caminho 
            move_uploaded_file($imagem["tmp_name"], $caminho_imagem);
        }
        // Se houver mensagens de erro, exibe-as 
        if (count($error) != 0) {
            foreach ($error as $erro) {
                $retorno = array('erro', $erro);
            }
        } else {
            $retorno = array('imagem', $caminho_imagem);
        }
        return $retorno;
    }

    public function arquivoUpload($arquivo, $maximo, $pathToSave) {    
        $retorno = array();
        //$pathToSave = $_SERVER["DOCUMENT_ROOT"]."/pasta onde quer salvar/";
        $pathToSave = (!$pathToSave) ? "images/" : $pathToSave;

        /* Checa se a pasta existe - caso negativo ele cria */
        if (!file_exists($pathToSave)) {
            mkdir($pathToSave);
        }
        // Verifica se o campo não está vazio.
        $dir = $pathToSave; // Diretório que vai receber o arquivo.
        $tmpName = $arquivo['arquivo']['tmp_name']; // Recebe o arquivo temporário.

        if ($arquivo['arquivo']['size'] > $maximo) {
            $retorno[0] = 'Erro';
            $retorno[1] = 'Tamanho do arquivo maior que o permitido';
            return $retorno;
            die;
        }

        $name = $arquivo['arquivo']['name']; // Recebe o nome do arquivo.
        preg_match_all('/\.[a-zA-Z0-9]+/', $name, $extensao);
        //array('.txt', '.pdf', '.doc', '.xls', '.xlms')
        if (!in_array(strtolower(current(end($extensao))), array('.pdf'))) {
            $retorno[0] = 'Erro';
            $retorno[1] = 'Permitido apenas arquivo pdf';
            return $retorno;
            die;
        }
        // Gera um nome único para a imagem 
        $nome_imagem = md5(uniqid(time())) . strtolower(current(end($extensao)));
        // move_uploaded_file( $arqTemporário, $nomeDoArquivo )
        if (move_uploaded_file($tmpName, "../".$pathToSave."/" . $nome_imagem)) { // move_uploaded_file irá realizar o envio do arquivo.        
            $retorno[0] = $pathToSave."/" . $nome_imagem;
            $retorno[1] = 'Arquivo adicionado com sucesso.';
            return $retorno;
            die;
        } else {
            $retorno[0] = 'Erro';
            $retorno[1] = 'Erro ao adicionar arquivo.';
            return $retorno;
            die;
        }
    }

    // ---------------------------------------------------------	// ---------------------------------------------------------
    // ---------------------------------------------------------	// ---------------------------------------------------------
    // ---------------------------------------------------------	// ---------------------------------------------------------
    // ---------------------------------------------------------	// ---------------------------------------------------------
    // ---------------------------------------------------------	// ---------------------------------------------------------
    // ---------------------------------------------------------	// ---------------------------------------------------------
    public function normalizeExtendedCharacters($str) {
        return strtr($str, "\xe1\xc1\xe0\xc0\xe2\xc2\xe4\xc4\xe3\xc3\xe5\xc5" .
                "\xaa\xe7\xc7\xe9\xc9\xe8\xc8\xea\xca\xeb\xcb\xed" .
                "\xcd\xec\xcc\xee\xce\xef\xcf\xf1\xd1\xf3\xd3\xf2" .
                "\xd2\xf4\xd4\xf6\xd6\xf5\xd5\x8\xd8\xba\xf0\xfa" .
                "\xda\xf9\xd9\xfb\xdb\xfc\xdc\xfd\xdd\xff\xe6\xc6\xdf", "aAaAaAaAaAaAacCeEeEeEeEiIiIiIiInNoOoOoOoOoOoOoouUuUuUuUyYyaAs");
    }

    public function normalizeXMLData($str = "") {
        $arReplace = array('"' => "&quot;",
            "'" => "&apos;",
            ">" => "&gt;",
            "<" => "&lt;",
            "&" => "&amp;");


        $str = strtr($str, $arReplace);
        return $str;
    }

    public function txtToHtmlID($str, $removeProp = true) {

        $arPreposicao = array("_a_",
            "_de_",
            "_do_",
            "_da_",
            "_o_");

        $str = str_replace(" ", "_", $str);
        $str = str_replace("'", "", $str);
        $str = str_replace('"', "", $str);
        $str = utf8_decode($str);
        $str = $this->normalizeExtendedCharacters($str);
        $str = utf8_encode($str);
        if ($removeProp) {
            $str = str_replace($arPreposicao, "_", $str);
        }
        return strtolower($str);
    }

    function makefilename() {
        $fname = uniqid() . uniqid();
        return $fname;
    }

    public function geoe($geo) {
        $ng = str_replace(" ", "", $geo);
        $ng = str_replace("/", "", $ng);
        $ng = strtolower($ng);
        return $ng;
    }

    public function validar_cnpj($cnpj) {
        $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);
        // Valida tamanho
        if (strlen($cnpj) != 14)
            return false;
        // Valida primeiro dígito verificador
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
            $soma += $cnpj{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        if ($cnpj{12} != ($resto < 2 ? 0 : 11 - $resto))
            return false;
        // Valida segundo dígito verificador
        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
            $soma += $cnpj{$i} * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }
        $resto = $soma % 11;
        return $cnpj{13} == ($resto < 2 ? 0 : 11 - $resto);
    }

//EOC
}

//class core
include('__paginacao.php');
// ---------------------------------------------------------
include ('__dicionario_views.php');
include('__fpdf.php');


?>