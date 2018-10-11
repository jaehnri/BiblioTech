<?php
    require_once 'validaCampos.class.php';

    class Conexao
    {
        public $con;
        protected $stmt; 
        protected $validar;
        protected $host = 'regulus.cotuca.unicamp.br';
        protected $database = 'BDPPI17170';
        protected $user = 'BDPPI17170';
        protected $senha = 'joaohenri123';
        
        public function __construct() {
            $connectionInfo = array("Database"=>$this->database,
            "PWD"=>$this->senha,
            "UID"=>$this->user);
            $this->con = sqlsrv_connect($this->host,$connectionInfo);
            //$this->con = new PDO("sqlsrv:server=$this->host; Database:$this->database; ConnectionPooling=0",
            //                     "$this->user", "$this->senha");
            
            //$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            if( $this->con === false )
                die( print_r( sqlsrv_errors(), true));
            
            $this->validar = new ValidaCampos();
            return true;
        }
        
        public function __destruct() {
            //sqlsrv_close($this->con);
            unset($this->con);
        }
        
        private function execSQL($consulta){
            if ($consulta === '') {
                return false;
            }
            
            $stmt = sqlsrv_query($this->con, $consulta);
            //$stmt = $this->con->query($consulta);
            
            if ($stmt) {
                $this->stmt = $stmt;
            } else {
                $this->sql_error($consulta);
            }
        }
        
        public function insertUsuario($NovoUsuario) {
            $usuarioAInserir = array();

            foreach ($NovoUsuario as $valor)
                array_push($usuarioAInserir, $this->validar->validar($valor));

            $sql = "INSERT INTO Usuario VALUES('".$usuarioAInserir['0']."','".$usuarioAInserir['1']."',
                                                '".$usuarioAInserir['2']."','".$usuarioAInserir['3']."',
                                                0,0)";
            
            $this->execSQL($sql);
            
        }
        
        public function selectCategoria($tipo, $filtroA)
        {
        	$filtro = $this->validar->validar($filtroA);

            //$sql = "SELECT CodCategoria, Nome, Tipo FROM Categoria where Tipo='".$tipo."' order by ".$filtro;
            $sql = '';
                
            if ($tipo != '')
            {
                $sql = "SELECT c.codCategoria, c.nome, c.codTipo FROM Categoria c, Tipo t WHERE 
                        c.codtipo = t.codTipo AND
                        c.codTipo = $tipo order by c.nome $filtro";
            }
            else
            {
                $sql = "SELECT c.codCategoria, c.nome, c.codTipo FROM Categoria c, Tipo t WHERE 
                        c.codtipo = t.codTipo order by c.nome $filtro";
            }
            $this->execSQL($sql);
            
            $dados='';
            
            while ($linha = sqlsrv_fetch_array($this->stmt, SQLSRV_FETCH_ASSOC))
                $dados[] = $linha;
            
            //while($linha = $this->con->fetch(PDO::FETCH_ASSOC))
             // $dados[] = $linha;
            
            return $dados;
        }
        
        public function selectCategoriaNome($nomeA)
        {
        	$nome = $this->validar->validar($nomeA);

            $sql = "SELECT codCategoria, nome, codTipo  FROM Categoria WHERE
                    nome = '$nome'";
            
            $this->execSQL($sql);
            
            $dados = '';
            while ($linha = sqlsrv_fetch_array($this->stmt, SQLSRV_FETCH_ASSOC))
                $dados[] = $linha;
            
            return $dados;
        }
        
        public function selectCategoriaCod ($codCategoria)
        {
            $sql="SELECT codCategoria, nome, codTipo FROM Categoria WHERE
                  codCategoria = $codCategoria";
            
            $this->execSQL($sql);
            
            $dados = '';
            while ($linha = sqlsrv_fetch_array($this->stmt, SQLSRV_FETCH_ASSOC))
                $dados[] = $linha;
            
            return $dados;
        }
        
        public function updateCategoria($cod, $novoNomeA, $novoTipo)
        {
        	$novoNome = $this->validar->validar($novoNomeA);

            $sql = "UPDATE Categoria SET nome = '$novoNome', codTipo = $novoTipo WHERE
                    codCategoria = $cod";
            
            $this->execSQL($sql);
            
        }
        
        public function deleteCategoria ($nomeA)
        {
        	$nome = $this->validar->validar($nomeA);

            $sql = "DELETE FROM Categoria WHERE nome = '$nome'";
            
            $this->execSQL($sql);
        }
        
        public function insertCategoria ($nomeA, $codTipo)
        {
        	$nome = $this->validar->validar($nomeA);

            $sql = "INSERT INTO Categoria values ('$nome', $codTipo)";
            
            $this->execSQL($sql);
            
        }
        public function selectMaterialUsuario ($codUsuario)
        {
            $sql = "SELECT m.codMaterial, m.nomeMaterial, m.localizacaoDoArquivo, m.data, m.codUsuario, m.codCategoria, m.descricao, 
             c.nome FROM Categoria c, Material m WHERE m.codUsuario = $codUsuario AND
             c.codCategoria = m.codCategoria";
            
            $this->execSQL($sql);
                
            $dados = '';
            
            while ($linha = sqlsrv_fetch_array($this->stmt, SQLSRV_FETCH_ASSOC))
                $dados[] = $linha;
            
            return $dados;
        }
        
        public function selectMaterialCod($codMaterial)
        {
            $sql = "SELECT m.codMaterial, m.nomeMaterial, m.localizacaoDoArquivo, m.data, m.codUsuario, m.codCategoria, m.descricao, 
             c.nome FROM Categoria c, Material m WHERE m.codMaterial = $codMaterial AND
             c.codCategoria = m.codCategoria";

            $this->execSQL($sql);

            $dados = '';
            while ($linha = sqlsrv_fetch_array($this->stmt, SQLSRV_FETCH_ASSOC))
                $dados[] = $linha;
             
            return $dados;
        }
        
        public function selectMaterial($buscaA, $categoriaA, $filtroA)
        {
        	$busca     = $this->validar->validar($buscaA);
        	$filtro    = $this->validar->validar($filtroA);
        	$categoria = $this->validar->validar($categoriaA);

            switch ($filtro)
            {
                case "Z-A": $ordem = "Desc"; break;
                case "maisRecente": $ordem = "Desc"; break;
                default: $ordem = ""; break;
            }
            
            if ($busca != "")
            {
                if ($categoria != "") //Maior select possível
                {
                    if ($filtro == "")
                    {
                        $sql = "SELECT m.codMaterial, m.nomeMaterial, m.localizacaoDoArquivo, m.data, m.codUsuario,
                            m.codCategoria, m.descricao, u.nomeUsuario FROM Material m, Categoria c, Usuario u WHERE
                            m.codCategoria = c.codCategoria AND
                            m.codUsuario = u.codUsuario AND
                            c.codCategoria = $categoria AND
                            m.nomeMaterial LIKE '%$busca%'";  
                    }
                        
                    if ($filtro == "menosRecente" || $filtro == "maisRecente")
                    {
                        $sql = "SELECT m.codMaterial, m.nomeMaterial, m.localizacaoDoArquivo, m.data, m.codUsuario,
                            m.codCategoria, m.descricao, u.nomeUsuario FROM Material m, Categoria c, Usuario u WHERE
                            m.codCategoria = c.codCategoria AND
                            m.codUsuario = u.codUsuario AND
                            c.codCategoria = $categoria AND
                            m.nomeMaterial LIKE '%$busca%' ORDER BY m.data $ordem";   
                    }
                    
                    if ($filtro == "A-Z" || $filtro == "Z-A")
                    {
                        $sql = "SELECT m.codMaterial, m.nomeMaterial, m.localizacaoDoArquivo, m.data, m.codUsuario,
                        m.codCategoria, m.descricao, u.nomeUsuario FROM Material m, Categoria c, Usuario u WHERE
                        m.codCategoria = c.codCategoria AND
                        m.codUsuario = u.codUsuario AND
                        c.codCategoria = $categoria AND
                        m.nomeMaterial LIKE '%$busca%' ORDER BY m.nomeMaterial $ordem"; 
                    }
                }
                else
                {
                    if ($filtro == "")
                    {
                        $sql = "SELECT m.codMaterial, m.nomeMaterial, m.localizacaoDoArquivo, m.data, m.codUsuario,
                            m.codCategoria, m.descricao, u.nomeUsuario FROM Material m, Usuario u WHERE
                            m.codUsuario = u.codUsuario AND                    
                            m.nomeMaterial LIKE '%$busca%'";    
                    }
                    
                    if ($filtro == "menosRecente" || $filtro == "maisRecente")
                    {
                        $sql = "SELECT m.codMaterial, m.nomeMaterial, m.localizacaoDoArquivo, m.data, m.codUsuario,
                            m.codCategoria, m.descricao, u.nomeUsuario FROM Material m, Usuario u WHERE
                            m.codUsuario = u.codUsuario AND                    
                            m.nomeMaterial LIKE '%$busca%' ORDER BY m.data $ordem";   
                    }
                    
                    if ($filtro == "A-Z" || $filtro == "Z-A")
                    {
                        $sql = "SELECT m.codMaterial, m.nomeMaterial, m.localizacaoDoArquivo, m.data, m.codUsuario,
                        m.codCategoria, m.descricao, u.nomeUsuario FROM Material m, Usuario u WHERE
                        m.codUsuario = u.codUsuario AND
                        m.nomeMaterial LIKE '%$busca%' ORDER BY m.nomeMaterial $ordem"; 
                    }
                }
                
            }
            else
            {
                if ($categoria != "")
                {
                    if ($filtro == "")
                    {
                        $sql = "SELECT m.codMaterial, m.nomeMaterial, m.localizacaoDoArquivo, m.data, m.codUsuario,
                            m.codCategoria, m.descricao, u.nomeUsuario FROM Material m, Categoria c, Usuario u WHERE
                            m.codCategoria = c.codCategoria AND
                            m.codUsuario = u.codUsuario AND
                            c.codCategoria = $categoria";    
                    }
                    
                    if ($filtro == "menosRecente" || $filtro == "maisRecente")
                    {
                        $sql = "SELECT m.codMaterial, m.nomeMaterial, m.localizacaoDoArquivo, m.data, m.codUsuario,
                            m.codCategoria, m.descricao, u.nomeUsuario FROM Material m, Categoria c, Usuario u WHERE
                            m.codCategoria = c.codCategoria AND
                            m.codUsuario = u.codUsuario AND
                            c.codCategoria = $categoria ORDER BY m.data $ordem";   
                    }
                    
                    if ($filtro == "A-Z" || $filtro == "Z-A")
                    {
                        $sql = "SELECT m.codMaterial, m.nomeMaterial, m.localizacaoDoArquivo, m.data, m.codUsuario,
                        m.codCategoria, m.descricao, u.nomeUsuario FROM Material m, Categoria c, Usuario u WHERE
                        m.codCategoria = c.codCategoria AND
                        m.codUsuario = u.codUsuario AND
                        c.codCategoria = $categoria ORDER BY m.nomeMaterial $ordem"; 
                    }
                }
                else
                {
                    if ($filtro == "")
                    {
                        $sql = "SELECT m.codMaterial, m.nomeMaterial, m.localizacaoDoArquivo, m.data, m.codUsuario,
                            m.codCategoria, m.descricao, u.nomeUsuario FROM Material m, Usuario u WHERE                        
                            m.codUsuario = u.codUsuario";   
                    }
                    
                    if ($filtro == "menosRecente" || $filtro == "maisRecente")
                    {
                        $sql = "SELECT m.codMaterial, m.nomeMaterial, m.localizacaoDoArquivo, m.data, m.codUsuario,
                            m.codCategoria, m.descricao, u.nomeUsuario FROM Material m, Usuario u WHERE                        
                            m.codUsuario = u.codUsuario ORDER BY m.data $ordem";   
                    }
                    
                    if ($filtro == "A-Z" || $filtro == "Z-A")
                    {
                        $sql = "SELECT m.codMaterial, m.nomeMaterial, m.localizacaoDoArquivo, m.data, m.codUsuario,
                        m.codCategoria, m.descricao, u.nomeUsuario FROM Material m, Usuario u WHERE                        
                        m.codUsuario = u.codUsuario ORDER BY m.nomeMaterial $ordem"; 
                    } 
                }
            }
            $this->execSQL($sql);
            
            $dados = "";
            
            while ($linha = sqlsrv_fetch_array($this->stmt, SQLSRV_FETCH_ASSOC))
                $dados[] = $linha;
            
            return $dados;
        }
        public function deleteMaterial ($codMaterial)
        {
            $sql = "DELETE FROM Material WHERE codMaterial = $codMaterial";
            
            $this->execSQL($sql);
        }
        
        public function insertMaterial($nomeMaterialA, $localizacaoDoArquivo, $codUsuario, $codCategoria, $descricaoA)
        {
        	$nomeMaterial = $this->validar->validar($nomeMaterialA);
        	$descricao    = $this->validar->validar($descricaoA);

            $sql  = "INSERT INTO Material(nomeMaterial, localizacaoDoArquivo, codUsuario, codCategoria, Descricao) ";
            //$sql .= "VALUES('".$nomeMaterial."', '".$localizacaoDoArquivo."', '".$data."', $codUsuario, $codCategoria, '".$descricao.'" )";
            $sql .= "VALUES('".$nomeMaterial."', '".$localizacaoDoArquivo."', $codUsuario, $codCategoria, '".$descricao."')";

            $this->execSQL($sql);
        }
        
        public function updateMaterial ($codMaterial, $novoNomeA, $novaCategoria)
        {
        	$novoNome = $this->validar->validar($novoNomeA);

            $sql = "UPDATE Material SET nomeMaterial = '$novoNome', codCategoria = $novaCategoria WHERE 
                    codMaterial = $codMaterial";
            
            $this->execSQL($sql);
        }
        
        public function usuarioJaExiste($usuario) {
            $sql = "SELECT * from Usuario where NomeUsuario='".$usuario."'";

            $this->execSQL($sql);

            $dados='';

            while ($linha = sqlsrv_fetch_array($this->stmt, SQLSRV_FETCH_ASSOC)) 
                $dados[] = $linha;
                
            //while($linha = $this->con->fetch(PDO::FETCH_ASSOC))
             // $dados[] = $linha;
            
            if (empty($dados))
                return false;
            else
                return true;
        }
        
        public function select($loginA,$senhaA)
        {
            $login = $this->validar->validar($loginA);
			$senha = $this->validar->validar($senhaA);

            $sql = "SELECT codUsuario, nomeUsuario, nomePessoa, email, senha, qtosMateriais, acessoADM
                    from Usuario where NomeUsuario='$login'";

            $this->execSQL($sql);

            $dados='';

            while ($linha = sqlsrv_fetch_array($this->stmt, SQLSRV_FETCH_ASSOC))
                $dados[] = $linha;
                
            //while($linha = $this->con->fetch(PDO::FETCH_ASSOC))
            //    $dados[] = $linha;
                
            
            foreach($dados as $i)
                if (password_verify($senha, $i['senha']))
                    return $dados;
                else
                    return false;
                
        }
        
        public function selectTipo()
        {
            $sql = "Select codTipo, nome From Tipo";
            
            $this->execSQL($sql);
            
            $dados = '';
            
            while ($linha = sqlsrv_fetch_array($this->stmt, SQLSRV_FETCH_ASSOC))
                $dados[] = $linha;
            
            return $dados;
        }
        
        private function sql_error($sql) {
            
            //echo sqlsrv_error($this->con) . '<br>';
            die('Erro na classe Conexao: ' . $sql);
        }
    }