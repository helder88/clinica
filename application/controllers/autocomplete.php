<?php

class Autocomplete extends Controller {

    function Autocomplete() {

        parent::Controller();
//        if ($this->session->userdata('autenticado') != true) {
//            redirect(base_url() . "login/index/login004", "refresh");
//        }
        $this->load->model('ponto/funcao_model', 'funcao');
        $this->load->model('ponto/funcionario_model', 'funcionario');
        $this->load->model('ponto/ocorrenciatipo_model', 'ocorrenciatipo');
        $this->load->model('ambulatorio/procedimento_model', 'procedimento');
        $this->load->model('ambulatorio/procedimentoplano_model', 'procedimentoplano');
        $this->load->model('ambulatorio/guia_model', 'guia');
        $this->load->model('ambulatorio/exametemp_model', 'exametemp');
        $this->load->model('ambulatorio/exame_model', 'exame');
        $this->load->model('estoque/fornecedor_model', 'fornecedor_m');
        $this->load->model('estoque/produto_model', 'produto_m');
        $this->load->model('estoque/armazem_model', 'armazem');
        $this->load->model('ambulatorio/laudo_model', 'laudo');
        $this->load->model('ponto/cargo_model', 'cargo');
        $this->load->model('ponto/setor_model', 'setor');
        $this->load->model('cadastro/paciente_model', 'paciente_m');
        $this->load->model('cadastro/contaspagar_model', 'contaspagar');
        $this->load->model('cadastro/classe_model', 'financeiro_classe');
        $this->load->model('cadastro/forma_model', 'forma');
        $this->load->model('seguranca/operador_model', 'operador_m');
        $this->load->model('emergencia/solicita_acolhimento_model', 'solicita_acolhimento_m');
        $this->load->model('internacao/internacao_model', 'internacao_m');
        $this->load->model('internacao/unidade_model', 'unidade_m');
        $this->load->model('internacao/enfermaria_model', 'enfermaria_m');
        $this->load->model('internacao/leito_model', 'leito_m');
        $this->load->model('ponto/horariostipo_model', 'horariostipo');
        $this->load->model('cadastro/formapagamento_model', 'formapagamento');
        $this->load->model('cadastro/classe_model', 'financeiro_classe');
        $this->load->model('estoque/menu_model', 'menu');
        $this->load->model('centrocirurgico/centrocirurgico_model', 'centrocirurgico');
    }

    function index() {
//        $this->listarhorariosmultiempresa();
    }

    function horariosambulatorio() {
        $_GET['teste'] = date("Y-m-d", strtotime(str_replace("/", "-", $_GET['teste'])));

        if (isset($_GET['exame'])) {
            $result = $this->exametemp->listarautocompletehorarios($_GET['exame'], $_GET['teste']);
        } else {
            $result = $this->exametemp->listarautocompletehorarios();
        }
        echo json_encode($result);
    }

    function gravarhorarioagendawebconvenio() {
        header('Access-Control-Allow-Origin: *');
        $paciente_id = $this->exametemp->crianovopacientefidelidade();
        $result = $this->exametemp->gravarpacienteconsultasweb($paciente_id);
//        var_dump($result); die;
        $retorno['data'] = $result[0]->data;
        $retorno['paciente_id'] = $result[0]->paciente_id;
        $var[] = $retorno;

        echo json_encode($var);
    }

    function procedimentoconveniocirurgico() {

        if (isset($_GET['convenio1'])) {
            $result = $this->centrocirurgico->listarautocompleteprocedimentoscirurgico($_GET['convenio1']);
        } else {
            $result = $this->centrocirurgico->listarautocompleteprocedimentoscirurgico();
        }
        echo json_encode($result);
    }

    function procedimentoconveniocirurgicoagrupador() {

        if (isset($_GET['convenio1'])) {
            $result = $this->centrocirurgico->listarautocompleteprocedimentoconveniocirurgicoagrupador($_GET['convenio1']);
        } else {
            $result = $this->centrocirurgico->listarautocompleteprocedimentoconveniocirurgicoagrupador();
        }
        echo json_encode($result);
    }

    function produtofarmacia() {

        if (isset($_GET['term'])) {
            $result = $this->produto_m->autocompleteprodutofarmacia($_GET['term']);
        } else {
            $result = $this->produto_m->autocompleteprodutofarmacia();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->descricao;
            $retorno['id'] = $item->farmacia_produto_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function fornecedorfarmacia() {

        if (isset($_GET['term'])) {
            $result = $this->fornecedor_m->autocompletefornecedorfarmacia($_GET['term']);
        } else {
            $result = $this->fornecedor_m->autocompletefornecedorfarmacia();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->fantasia;
            $retorno['id'] = $item->farmacia_fornecedor_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function prescricaomedicamento() {

        if (isset($_GET['term'])) {
            $result = $this->internacao_m->listarautocompletemedicamentoprescricao($_GET['term']);
        } else {
            $result = $this->internacao_m->listarautocompletemedicamentoprescricao();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->descricao;
            $retorno['id'] = $item->farmacia_produto_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function saldofarmacia() {

        if (isset($_GET['entrada_id'])) {
            $result = $this->saida_farmacia_m->listarsaldoprodutofarmaciaautocomplete($_GET['entrada_id']);
        } else {
            $result = $this->saida_farmacia_m->listarsaldoprodutofarmaciaautocomplete();
        }
//        var_dump($result); die;
        foreach ($result as $item) {
            $retorno['value'] = $item->total;
//            $retorno['id'] = $item->estoque_produto_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function saidaprescricaofarmacia() {

        if (isset($_GET['prescricao_id'])) {
            $result = $this->saida_farmacia_m->listarsaidaprescricaofarmaciaautocomplete($_GET['prescricao_id']);
        } else {
            $result = $this->saida_farmacia_m->listarsaidaprescricaofarmaciaautocomplete();
        }
//        var_dump($result); die;
        foreach ($result as $item) {
            $retorno['value'] = $item->total;
//            $retorno['id'] = $item->estoque_produto_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function produtofarmaciafracionamento() {

        if (isset($_GET['term'])) {
            $result = $this->produto_m->autocompleteprodutofarmaciafracionamento($_GET['term']);
        } else {
            $result = $this->produto_m->autocompleteprodutofarmaciafracionamento();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->descricao;
            $retorno['id'] = $item->farmacia_produto_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function listarhorarioagendawebconvenio() {
        header('Access-Control-Allow-Origin: *');
//        var_dump($_GET); die;
        $convenio = $this->procedimentoplano->listarconveniointegracaofidelidade($_GET['parceiro_id']);
        echo json_encode($convenio);
    }

    function enviaremailstg() {
        header('Access-Control-Allow-Origin: *');
//        var_dump($_POST);
//        die;
        if ($_POST['human'] == '4') {


            $this->load->library('email');

            $config['protocol'] = 'smtp';
            $config['smtp_host'] = 'ssl://smtp.gmail.com';
            $config['smtp_port'] = '465';
            $config['smtp_user'] = 'equipe2016gcjh@gmail.com';
            $config['smtp_pass'] = 'DUCOCOFRUTOPCE';
            $config['validate'] = TRUE;
            $config['mailtype'] = 'html';
            $config['charset'] = 'utf-8';
            $config['newline'] = "\r\n";
            $email = $_POST['message'] . "<br>  "
                    . "<br> Nome: {$_POST['name']}"
                    . "<br> Telefone: {$_POST['telefone']}"
                    . "<br> Email: {$_POST['email']}";

            $this->email->initialize($config);
            $this->email->from('equipe2016gcjh@gmail.com', $_POST['name']);
            $this->email->to('contato@stgsaude.com.br');
            $this->email->subject($_POST['subject']);
            $this->email->message($email);
            if ($this->email->send()) {
                $mensagem = "Email enviado com sucesso.";
            } else {
                $mensagem = "Envio de Email malsucedido.";
            }
            echo "<html>
            <meta charset='UTF-8'>
        <script type='text/javascript'>
        alert('$mensagem');
        window.location.href = 'http://stgsaude.com.br';
            </script>
            </html>";
//        redirect("http://stgsaude.com.br");
        } else {
            echo "<html>
            <meta charset='UTF-8'>
        <script type='text/javascript'>
        alert('Você respondeu o anti-spam errado');
        window.location.href = 'http://stgsaude.com.br';
            </script>
            </html>";
        }
    }

    function autorizaragendaweb() {
        header('Access-Control-Allow-Origin: *');

        $parceiro = $this->parceiro->listarparceiroendereco($parceiro_id);
        @$endereco = $parceiro[0]->endereco_ip;
        @$parceiro_gravar_id = $parceiro[0]->financeiro_parceiro_id;
        $cpf = $cpf_array[0]->cpf;
        // BUSCANDO O GRUPO DO PROCEDIMENTO NA CLINICA

        $grupo_busca = file_get_contents("http://{$endereco}/autocomplete/listargrupoagendamentoweb?procedimento_convenio_id={$_POST['procedimento']}");
        $grupo = json_decode($grupo_busca);

        //LISTANDO AS INFORMAÇÕES DE CARÊNCIA E PARCELAS PAGAS PELO PACIENTE

        $parcelas = $this->guia->listarparcelaspaciente($_POST['txtNomeid']);
        $carencia = $this->guia->listarparcelaspacientecarencia($_POST['txtNomeid']);

        $listaratendimento = $this->guia->listaratendimentoparceiro($paciente_id);
        $carencia_exame = $carencia[0]->carencia_exame;
        $carencia_consulta = $carencia[0]->carencia_consulta;
        $carencia_especialidade = $carencia[0]->carencia_especialidade;

        // COMPARANDO O GRUPO E ESCOLHENDO O VALOR DE CARÊNCIA PARA O GRUPO DESEJADO
        if ($grupo == 'EXAME') {
            $carencia = (int) $carencia_exame;
        } elseif ($grupo == 'CONSULTA') {
            $carencia = (int) $carencia_consulta;
        } elseif ($grupo == 'FISIOTERAPIA') {
            $carencia = (int) $carencia_especialidade;
        }
        // 

        $dias_parcela = 30 * count($parcelas);
        $dias_atendimento = $carencia * count($listaratendimento);


        if (($dias_parcela - $dias_atendimento) >= $carencia) {
            return json_encode(true);
        } else {
            return json_encode(false);
        }
        die;
    }

//    function unidadeleito() {
//
//        if (isset($_GET['unidade'])) {
//            $result = $this->internacao_m->listaleitointarnacao($_GET['unidade']);
//        } else {
//            $result = $this->internacao_m->listaleitointarnacao();
//        }
//        echo json_encode($result);
//    }

    function unidadeleito2() {

        if (isset($_GET['unidade'])) {
            $result = $this->internacao_m->listaleitointarnacao2($_GET['unidade']);
        } else {
            $result = $this->internacao_m->listaleitointarnacao2();
        }
        echo json_encode($result);
    }

    function unidadepaciente() {

        if (isset($_GET['unidade'])) {
            $result = $this->internacao_m->listapacienteunidade($_GET['unidade']);
        } else {
            $result = $this->internacao_m->listapacienteunidade();
        }
        echo json_encode($result);
    }

    function listarmedicoweb() {
        header('Access-Control-Allow-Origin: *');
//        var_dump($_GET); die;
        $medicos = $this->operador_m->listarmedicos();
        echo json_encode($medicos);
    }

    function listarhorarioagendaweb() {
        header('Access-Control-Allow-Origin: *');
        $agenda_exames_id = $_GET['agenda_exames_id'];
        $consultas = $this->exametemp->listaragendasconsultapaciente($agenda_exames_id);
        echo json_encode($consultas);
    }

    function listarexameagendamentoweb() {
        header('Access-Control-Allow-Origin: *');

        $result = $this->exame->listaragendamentoweb()->limit($_GET['limit'], $_GET['pagina'])->get()->result();
        echo json_encode($result);
    }

    function listarexameagendamentowebcpf() {
        header('Access-Control-Allow-Origin: *');
//        var_dump($_GET); die;
        $result = $this->exame->listaragendamentowebcpf()->limit($_GET['limit'], $_GET['pagina'])->get()->result();
//        var_dump($result); die;
        echo json_encode($result);
    }

    function listargrupoagendamentoweb() {
//        var_dump($_GET); die;
        header('Access-Control-Allow-Origin: *');

        if (isset($_GET['procedimento_convenio_id'])) {
            $result = $this->exametemp->listarautocompletegrupoweb(@$_GET['procedimento_convenio_id']);
        } else {
            $result = $this->exametemp->listarautocompletegrupoweb(@$_GET['procedimento_convenio_id']);
        }

        echo json_encode($result[0]->tipo);
    }

    function excluirconsultaweb() {
        $agenda_exames_id = $_GET['agenda_exames_id'];
//        var_dump($agenda_exames_id); die;
        $this->exametemp->excluirexametemp($agenda_exames_id);
        echo json_encode(true);
    }

    function buscarvalorprocedimentoagrupados() {
        $result = array();

        if (isset($_GET['convenio']) && isset($_GET['procedimento_id'])) {
            $result = $this->exametemp->buscarvalorprocedimentoagrupados($_GET['convenio'], $_GET['procedimento_id']);
        }

        die(json_encode($result));
    }

    function buscaexamesanteriores() {
        $result = array();

        if (isset($_GET['paciente_id']) && isset($_GET['procedimento_id'])) {
            $result = $this->exametemp->buscaexamesanteriores($_GET['paciente_id'], $_GET['procedimento_id']);
        }

        echo json_encode($result);
    }

    function validaretornoprocedimento() {
        $result = array();

        if (isset($_GET['paciente_id']) && isset($_GET['procedimento_id'])) {
            $result = $this->exametemp->validaretornoprocedimento($_GET['paciente_id'], $_GET['procedimento_id']);
        }

        echo json_encode($result);
    }

    function validaretornoprocedimentoinverso() {
        $result = array();


        if (isset($_GET['paciente_id']) && isset($_GET['procedimento_id'])) {
            $result = $this->exametemp->validaretornoprocedimentoinverso($_GET['paciente_id'], $_GET['procedimento_id']);
        }

        echo json_encode($result);
    }

    function buscaconsultasanteriores() {
        $result = array();

        if (isset($_GET['paciente_id']) && isset($_GET['procedimento_id'])) {
            $result = $this->exametemp->buscaconsultasanteriores($_GET['paciente_id'], $_GET['procedimento_id']);
        }

        echo json_encode($result);
    }

    function horariosambulatorioexame() {
        $_GET['teste'] = date("Y-m-d", strtotime(str_replace("/", "-", $_GET['teste'])));

        if (isset($_GET['exame'])) {
            $result = $this->exametemp->listarautocompletehorariosexame($_GET['exame'], $_GET['teste']);
        } else {
            $result = $this->exametemp->listarautocompletehorariosexame();
        }
        echo json_encode($result);
    }

    function unidadeleito() {

        if (isset($_GET['unidade'])) {
            $result = $this->internacao_m->listaleitointarnacao($_GET['unidade']);
        } else {
            $result = $this->internacao_m->listaleitointarnacao();
        }
        echo json_encode($result);
    }

    function buscarprocedimentoconvenioprincipal() {
        if (isset($_GET['convenio'])) {
            $result = $this->procedimentoplano->buscarprocedimentoconvenioprincipal($_GET['convenio']);
        } else {
            $result = $this->procedimentoplano->buscarprocedimentoconvenioprincipal();
        }
        echo json_encode($result);
    }

    function buscarprocedimentoconveniosecundario() {
        if (isset($_GET['convenio'])) {
            $result = $this->procedimentoplano->buscarprocedimentoconveniosecundario($_GET['convenio']);
        } else {
            $result = $this->procedimentoplano->buscarprocedimentoconveniosecundario();
        }
        echo json_encode($result);
    }

    function buscarconveniosecundario() {
        if (isset($_GET['convenio'])) {
            $result = $this->procedimentoplano->buscarconveniosecundario($_GET['convenio']);
        } else {
            $result = $this->procedimentoplano->buscarconveniosecundario();
        }
        echo json_encode($result);
    }

    function horariosambulatorioconsulta() {
        $_GET['teste'] = date("Y-m-d", strtotime(str_replace("/", "-", $_GET['teste'])));
        if (isset($_GET['exame'])) {
            $result = $this->exametemp->listarhorariosconsulta($_GET['exame'], $_GET['teste']);
        } else {
            $result = $this->exametemp->listarhorariosconsulta();
        }
        echo json_encode($result);
    }

    function horariosambulatorioespecialidade() {
//    $_GET['teste'] = date('Y-m-d',$_GET['teste'] );
        $_GET['teste'] = date("Y-m-d", strtotime(str_replace("/", "-", $_GET['teste'])));
        if (isset($_GET['exame'])) {
            $result = $this->exametemp->listarhorariosespecialidade($_GET['exame'], $_GET['teste']);
        } else {
            $result = $this->exametemp->listarhorariosespecialidade();
        }
        echo json_encode($result);
    }

    function horariosambulatorioespecialidadepersonalizado() {
//    $_GET['teste'] = date('Y-m-d',$_GET['teste'] );
        $_GET['teste'] = date("Y-m-d", strtotime(str_replace("/", "-", $_GET['teste'])));
        if (isset($_GET['exame'])) {
            $result = $this->exametemp->listarhorariosespecialidadepersonalizado($_GET['exame'], $_GET['teste']);
        } else {
            $result = $this->exametemp->listarhorariosespecialidadepersonalizado();
        }
        echo json_encode($result);
    }

    function armazemtransferenciaentrada() {
//    $_GET['teste'] = date('Y-m-d',$_GET['teste'] );
        if (isset($_GET['produto'])) {
            $result = $this->armazem->armazemtransferenciaentradajson($_GET['produto'], $_GET['armazem']);
        } else {
            $result = $this->armazem->armazemtransferenciaentradajson();
        }
        echo json_encode($result);
    }

    function armazemtransferenciaentradaproduto() {
//    $_GET['teste'] = date('Y-m-d',$_GET['teste'] );
        if (isset($_GET['produto'])) {
            $result = $this->armazem->armazemtransferenciaentradaproduto($_GET['produto'], $_GET['armazem']);
        } else {
            $result = $this->armazem->armazemtransferenciaentradaproduto();
        }
        echo json_encode($result);
    }

    function armazemtransferenciaentradaquantidade() {
//    $_GET['teste'] = date('Y-m-d',$_GET['teste'] );
        if (isset($_GET['produto'])) {
            $result = $this->armazem->armazemtransferenciaentradajsonquantidade($_GET['produto']);
        } else {
            $result = $this->armazem->armazemtransferenciaentradajsonquantidade();
        }
        echo json_encode($result);
    }

    function armazemtransferenciaentradaquantidadegastos() {
//    $_GET['teste'] = date('Y-m-d',$_GET['teste'] );
        if (isset($_GET['produto'])) {
            $result = $this->armazem->armazemtransferenciaentradajsonquantidadegasto($_GET['produto'], $_GET['armazem']);
        } else {
            $result = $this->armazem->armazemtransferenciaentradajsonquantidadegasto();
        }
        echo json_encode($result);
    }

    function horariosambulatoriogeral() {

        if (isset($_GET['exame'])) {
            $result = $this->exametemp->listarhorariosgeral($_GET['exame'], $_GET['teste']);
        } else {
            $result = $this->exametemp->listarhorariosgeral();
        }
        echo json_encode($result);
    }

    function listarprocedimentointernacaoautocomplete() {
        if (isset($_GET['term'])) {
            $result = $this->procedimento->listarprocedimentoautocomplete($_GET['term']);
        } else {
            $result = $this->procedimento->listarprocedimentoautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->procedimento_tuss_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function listarprocedimentoautocomplete() {
        if (isset($_GET['term'])) {
            $result = $this->procedimento->listarprocedimentoautocomplete($_GET['term']);
        } else {
            $result = $this->procedimento->listarprocedimentoautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->procedimento_tuss_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function procedimentoproduto() {
        if (isset($_GET['term'])) {
            $result = $this->procedimento->listarprocedimentoautocomplete($_GET['term']);
        } else {
            $result = $this->procedimento->listarprocedimentoautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->procedimento_tuss_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function procedimentocirurgia() {
        if (isset($_GET['procedimento_id'])) {
            $result = $this->procedimento->listarprocedimentocirurgia2autocomplete($_GET['procedimento_id'], $_GET['convenio_id']);
        } else {
            $result = $this->procedimento->listarprocedimentocirurgia2autocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->codigo . " - " . $item->nome;
            $retorno['id'] = $item->procedimento_tuss_id;
            $retorno['valor'] = $item->procedimento_tuss_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function procedimentoconveniocirurgia() {

        if (isset($_GET['procedimento'])) {
            $result = $this->procedimento->listarprocedimentocirurgiaautocomplete($_GET['procedimento']);
        } else {
            $result = $this->procedimento->listarprocedimentocirurgiaautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->descricao;
            $retorno['id'] = $item->procedimento_convenio_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function listarespecialidademultiempresa() {
        header('Access-Control-Allow-Origin: *');

        $result = $this->exametemp->listarespecialidademultiempresa();

        foreach ($result as $item) {
            $retorno['cbo_ocupacao_id'] = $item->cbo_ocupacao_id;
            $retorno['descricao'] = $item->descricao;
            @$var[] = $retorno;
        }
        echo json_encode($var);
    }

    function listarmedicosmultiempresa() {
        header('Access-Control-Allow-Origin: *');

        $result = $this->exametemp->listarmedicosmultiempresa();

        foreach ($result as $item) {
            $retorno['operador_id'] = $item->operador_id;
            $retorno['nome'] = $item->nome;
            $retorno['conselho'] = $item->conselho;
            @$var[] = $retorno;
        }
        echo json_encode($var);
    }

    function listarconsultaspacientemultiempresa() {
        header('Access-Control-Allow-Origin: *');
        $agenda_exames_id = $_POST['agenda_exames_id'];
//        $agenda_exames_id = 911481;

        $result = $this->exametemp->listarconsultaspacientemultiempresa($agenda_exames_id);

        foreach ($result as $item) {
            $retorno['agenda_exames_id'] = $item->agenda_exames_id;
            $retorno['inicio'] = $item->inicio;
            $retorno['data'] = $item->data;
            $retorno['nome'] = $item->nome;
            $retorno['medico'] = $item->medico;
            $retorno['medico_agenda'] = $item->medico_agenda;
            $retorno['observacoes'] = $item->observacoes;
            @$var[] = $retorno;
        }
        echo json_encode($var);
    }

    function listarconveniomultiempresa() {
        $result = $this->exametemp->listarconveniomultiempresa();
        foreach ($result as $item) {
            $retorno['convenio_id'] = $item->convenio_id;
            $retorno['nome'] = $item->nome;
            @$var[] = $retorno;
        }
        echo json_encode($var);
    }

    function listarhorariosmultiempresa() {
//        var_dump(date("Y-m-d", strtotime(str_replace('/', '-', $_GET['data'])))); 
//        die;
        $result = $this->exametemp->listarhorariosmultiempresa();
//        var_dump($result); 
//        die;
        foreach ($result as $item) {

            $retorno['agenda_exames_id'] = $item->agenda_exames_id;
            $retorno['inicio'] = $item->inicio;
            $retorno['fim'] = $item->fim;
            $retorno['situacao'] = $item->situacao;
            $retorno['data'] = $item->data;
            $retorno['situacaoexame'] = $item->situacaoexame;
            $retorno['paciente'] = $item->paciente;
            $retorno['paciente_id'] = $item->paciente_id;
            $retorno['medicoagenda'] = $item->medicoagenda;
            $retorno['medico_agenda'] = $item->medico_agenda;
            $retorno['convenio'] = $item->convenio;
            $retorno['convenio_paciente'] = $item->convenio_paciente;
            $retorno['realizada'] = $item->realizada;
            $retorno['confirmado'] = $item->confirmado;
            $retorno['procedimento'] = $item->procedimento;
            $retorno['celular'] = $item->celular;
            $retorno['telefone'] = $item->telefone;
            $retorno['operador_atualizacao'] = $item->operador_atualizacao;
            $retorno['ocupado'] = $item->ocupado;
            $retorno['bloqueado'] = $item->bloqueado;
            $retorno['telefonema'] = $item->telefonema;
            $retorno['telefonema_operador'] = $item->telefonema_operador;
            $retorno['tipo'] = $item->tipo;
            @$var[] = $retorno;
        }
        echo json_encode($var);
    }

    function listarhorarioscalendario() {
//            echo $_POST['custom_param1'];
        if (count($_POST) > 0) {
            $result = $this->exametemp->listarhorarioscalendariovago($_POST['medico'], null, $_POST['empresa'], $_POST['sala'], $_POST['grupo'], $_POST['tipoagenda']);
//            $algo = 'asd';
        } else {
            $result = $this->exametemp->listarhorarioscalendariovago();
//            $algo = 'dsa';
        }

        $var = Array();
        $i = 0;
//            $result2 = $this->exametemp->listarhorarioscalendarioocupado();

        foreach ($result as $item) {
            $i++;
            $retorno['id'] = $i;
            if ($item->situacao == 'LIVRE') {
                $retorno['title'] = 'V: ' . $item->contagem;
            } else {
                $retorno['title'] = 'M: ' . $item->contagem;
            }

            $retorno['start'] = $item->data;
            $retorno['end'] = $item->data;
            if ($item->situacao == 'LIVRE') {
                $retorno['color'] = '#62C462';
            } else {
                $retorno['color'] = '#B30802';
            }
            $situacao = $item->situacao;
            if (isset($item->medico)) {
                $medico = $item->medico;
            } else {
                $medico = null;
            }
            if ($_POST['tipoagenda']) {
                $tipoagenda = $_POST['tipoagenda'];
            } else {
                $tipoagenda = null;
            }
            if ($_POST['paciente'] != '') {
                $nome = $_POST['paciente'];
            } else {
                $nome = null;
            }
            $sala = $_POST['sala'];
            $grupo = $_POST['grupo'];
            $empresa = $_POST['empresa'];

            $dia = date("d", strtotime($item->data));
            $mes = date("m", strtotime($item->data));
            $ano = date("Y", strtotime($item->data));

//            $medico = $item->medico;
            if ($this->session->userdata('calendario_layout') == 't') {
                $retorno['url'] = "../../ambulatorio/exame/listarmultifuncaocalendario2?empresa=$empresa&grupo=$grupo&sala=$sala&tipoagenda=$tipoagenda&medico=$medico&situacao=$situacao&data=$dia%2F$mes%2F$ano&nome=$nome";
            } else {
                $retorno['url'] = "../../ambulatorio/exame/listarmultifuncaocalendario?empresa=$empresa&grupo=$grupo&sala=$sala&tipoagenda=$tipoagenda&medico=$medico&situacao=$situacao&data=$dia%2F$mes%2F$ano&nome=$nome";
            }

            $var[] = $retorno;
        }
        echo json_encode($var);

//        foreach ($result2 as $value) {
//            $retorno['title'] =  'H: Ocupados: ' . $value->contagem_ocupado;
//            $retorno['start'] = $value->data;
//            $retorno['end'] = $value->data;
//            $retorno['color'] = '#0E9AA7';
//            $dia = date("d", strtotime($item->data));
//            $mes = date("m", strtotime($item->data));
//            $ano = date("Y", strtotime($item->data));
//            $retorno['url'] = "../../ambulatorio/exame/listarmultifuncaoconsulta?empresa=&especialidade=&medico=&situacao=OK&data=$dia%2F$mes%2F$ano&nome=";
//            $var[] = $retorno;
//        }
    }

    function listarhorarioscalendarioexame() {
//            echo $_POST['custom_param1'];
        if (isset($_POST['medico']) || isset($_POST['especialidade']) || isset($_POST['empresa']) || isset($_POST['sala'])) {
            $result = $this->exametemp->listarhorarioscalendarioexame($_POST['medico'], $_POST['especialidade'], $_POST['empresa'], $_POST['sala'], $_POST['grupo']);
        } else {
            $result = $this->exametemp->listarhorarioscalendarioexame();
        }

        $var = Array();
        $i = 0;
//            $result2 = $this->exametemp->listarhorarioscalendarioocupado();

        foreach ($result as $item) {
            $i++;
            $retorno['id'] = $i;
            if ($item->situacao == 'LIVRE') {
                $retorno['title'] = 'V: ' . $item->contagem;
            } else {
                $retorno['title'] = 'M: ' . $item->contagem;
            }

            $retorno['start'] = $item->data;
            $retorno['end'] = $item->data;
            if ($item->situacao == 'LIVRE') {
                $retorno['color'] = '#62C462';
            } else {
                $retorno['color'] = '#B30802';
            }
            $situacao = $item->situacao;
            if (isset($item->medico)) {
                $medico = $item->medico;
            } else {
                $medico = null;
            }
            if ($_POST['especialidade']) {
                $especialidade = $_POST['especialidade'];
            } else {
                $especialidade = null;
            }
            if ($_POST['paciente'] != '') {
                $nome = $_POST['paciente'];
            } else {
                $nome = null;
            }
            $sala = $_POST['sala'];
            $grupo = $_POST['grupo'];
            $empresa = $_POST['empresa'];

            $dia = date("d", strtotime($item->data));
            $mes = date("m", strtotime($item->data));
            $ano = date("Y", strtotime($item->data));

//            $medico = $item->medico;

            $retorno['url'] = "../../ambulatorio/exame/listarmultifuncaoexamecalendario?empresa=$empresa&grupo=$grupo&sala=$sala&especialidade=$especialidade&medico=$medico&situacao=$situacao&data=$dia%2F$mes%2F$ano&nome=$nome";


            $var[] = $retorno;
        }
        echo json_encode($var);

//        foreach ($result2 as $value) {
//            $retorno['title'] =  'H: Ocupados: ' . $value->contagem_ocupado;
//            $retorno['start'] = $value->data;
//            $retorno['end'] = $value->data;
//            $retorno['color'] = '#0E9AA7';
//            $dia = date("d", strtotime($item->data));
//            $mes = date("m", strtotime($item->data));
//            $ano = date("Y", strtotime($item->data));
//            $retorno['url'] = "../../ambulatorio/exame/listarmultifuncaoconsulta?empresa=&especialidade=&medico=&situacao=OK&data=$dia%2F$mes%2F$ano&nome=";
//            $var[] = $retorno;
//        }
    }

    function listarhorarioscalendarioconsulta() {
//            echo $_POST['custom_param1'];
        if (isset($_POST['medico']) || isset($_POST['tipoagenda']) || isset($_POST['empresa'])) {
            $result = $this->exametemp->listarhorarioscalendarioconsulta($_POST['medico'], $_POST['tipoagenda'], $_POST['empresa']);
        } else {
            $result = $this->exametemp->listarhorarioscalendarioconsulta();
        }

        $var = Array();
        $i = 0;
//            $result2 = $this->exametemp->listarhorarioscalendarioocupado();

        foreach ($result as $item) {
            $i++;
            $retorno['id'] = $i;
            if ($item->situacao == 'LIVRE') {
                $retorno['title'] = 'V: ' . $item->contagem;
            } else {
                $retorno['title'] = 'M: ' . $item->contagem;
            }

            $retorno['start'] = $item->data;
            $retorno['end'] = $item->data;
            if ($item->situacao == 'LIVRE') {
                $retorno['color'] = '#62C462';
            } else {
                $retorno['color'] = '#B30802';
            }
            $situacao = $item->situacao;
            if (isset($item->medico)) {
                $medico = $item->medico;
            } else {
                $medico = null;
            }
            if ($_POST['tipoagenda']) {
                $tipoagenda = $_POST['tipoagenda'];
            } else {
                $tipoagenda = null;
            }
            if ($_POST['paciente'] != '') {
                $nome = $_POST['paciente'];
            } else {
                $nome = null;
            }

            $dia = date("d", strtotime($item->data));
            $mes = date("m", strtotime($item->data));
            $ano = date("Y", strtotime($item->data));

//            $medico = $item->medico;

            $retorno['url'] = "../../ambulatorio/exame/listarmultifuncaoconsultacalendario?empresa=&tipoagenda=$tipoagenda&medico=$medico&situacao=$situacao&data=$dia%2F$mes%2F$ano&nome=$nome";


            $var[] = $retorno;
        }
        echo json_encode($var);

//        foreach ($result2 as $value) {
//            $retorno['title'] =  'H: Ocupados: ' . $value->contagem_ocupado;
//            $retorno['start'] = $value->data;
//            $retorno['end'] = $value->data;
//            $retorno['color'] = '#0E9AA7';
//            $dia = date("d", strtotime($item->data));
//            $mes = date("m", strtotime($item->data));
//            $ano = date("Y", strtotime($item->data));
//            $retorno['url'] = "../../ambulatorio/exame/listarmultifuncaoconsulta?empresa=&especialidade=&medico=&situacao=OK&data=$dia%2F$mes%2F$ano&nome=";
//            $var[] = $retorno;
//        }
    }

    function listarhorarioscalendarioespecialidade() {
//            echo $_POST['custom_param1'];
        if (isset($_POST['medico']) || isset($_POST['tipoagenda']) || isset($_POST['empresa'])) {
            $result = $this->exametemp->listarhorarioscalendarioespecialidade($_POST['medico'], $_POST['tipoagenda'], $_POST['empresa']);
        } else {
            $result = $this->exametemp->listarhorarioscalendarioespecialidade();
        }

        $var = Array();
        $i = 0;
//            $result2 = $this->exametemp->listarhorarioscalendarioocupado();

        foreach ($result as $item) {
            $i++;
            $retorno['id'] = $i;
            if ($item->situacao == 'LIVRE') {
                $retorno['title'] = 'V: ' . $item->contagem;
            } else {
                $retorno['title'] = 'M: ' . $item->contagem;
            }

            $retorno['start'] = $item->data;
            $retorno['end'] = $item->data;
            if ($item->situacao == 'LIVRE') {
                $retorno['color'] = '#62C462';
            } else {
                $retorno['color'] = '#B30802';
            }
            $situacao = $item->situacao;
            if (isset($item->medico)) {
                $medico = $item->medico;
            } else {
                $medico = null;
            }
            if ($_POST['especialidade']) {
                $especialidade = $_POST['especialidade'];
            } else {
                $especialidade = null;
            }
            if ($_POST['empresa'] != '') {
                $empresa_id = $_POST['empresa'];
            } else {
                $empresa_id = '';
            }
            if ($_POST['paciente'] != '') {
                $nome = $_POST['paciente'];
            } else {
                $nome = null;
            }

            $dia = date("d", strtotime($item->data));
            $mes = date("m", strtotime($item->data));
            $ano = date("Y", strtotime($item->data));

//            $medico = $item->medico;

            $retorno['url'] = "../../ambulatorio/exame/listarmultifuncaoespecialidadecalendario?empresa=$empresa_id&especialidade=$especialidade&medico=$medico&situacao=$situacao&data=$dia%2F$mes%2F$ano&nome=$nome";


            $var[] = $retorno;
        }
        echo json_encode($var);

//        foreach ($result2 as $value) {
//            $retorno['title'] =  'H: Ocupados: ' . $value->contagem_ocupado;
//            $retorno['start'] = $value->data;
//            $retorno['end'] = $value->data;
//            $retorno['color'] = '#0E9AA7';
//            $dia = date("d", strtotime($item->data));
//            $mes = date("m", strtotime($item->data));
//            $ano = date("Y", strtotime($item->data));
//            $retorno['url'] = "../../ambulatorio/exame/listarmultifuncaoconsulta?empresa=&especialidade=&medico=&situacao=OK&data=$dia%2F$mes%2F$ano&nome=";
//            $var[] = $retorno;
//        }
    }

    function centrocirurgicomedicos() {
//        var_dump(123);die;

        if (isset($_GET['term'])) {
            $result = $this->centrocirurgico->listarmedicocirurgiaautocomplete($_GET['term']);
        } else {
            $result = $this->centrocirurgico->listarmedicocirurgiaautocomplete();
        }
        foreach ($result as $item) {
            $retorno['nome'] = $item->nome;
            $retorno['id'] = $item->operador_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }
    
    function alterardatacirurgiajson() {
//        var_dump(123);die;

        if (isset($_GET['solicitacao_id'])) {
            $this->centrocirurgico->alterardatacirurgiajson($_GET['solicitacao_id']);
            $retorno = true;
        } else {
            $retorno = false;
        }
        
        echo json_encode($retorno);
    }

    function carregavalorprocedimentocirurgico() {

        if (isset($_GET['procedimento_id']) && isset($_GET['equipe_id'])) {
            $procedimento_valor = $this->procedimento->carregavalorprocedimentocirurgico($_GET['procedimento_id']);
            $equipe = $this->exame->listarquipeoperadores($_GET['equipe_id']);

            $valorProcedimento = ((float) ($procedimento_valor[0]->valor_total));
            $valorCirurgiao = 0;
            $valorAnestesista = 0;

            foreach ($equipe as $value) {
                if ($value->funcao == '00') {//cirurgiao
                } elseif ($value->funcao == '00') {//anestesista
                }
            }
        }
        echo json_encode($result);
    }

    function procedimentoconveniomedicocadastrosala() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentoconveniomedicocadastrosala($_GET['convenio1'], $_GET['teste'], $_GET['sala']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentoconveniomedicocadastrosala();
        }
        echo json_encode($result);
    }

    function procedimentoconveniomedicocadastro() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconveniomedicocadastro($_GET['convenio1'], $_GET['teste']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconveniomedicocadastro();
        }
        echo json_encode($result);
    }

    function procedimentoconveniomedico() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconveniomedico($_GET['convenio1'], $_GET['teste'], $_GET['empresa_id']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconveniomedico();
        }
        echo json_encode($result);
    }

    function buscarsaldopacientefaturar() {
        if (isset($_GET['paciente_id'])) {

            $paciente_id = $_GET['paciente_id'];

            $saldoCredito = $this->exametemp->listarsaldocreditopaciente($paciente_id);
        }

        echo json_encode(array("saldo" => $saldoCredito[0]->saldo, "paciente_id" => $paciente_id));
    }

    function buscarsaldopaciente() {
        if (isset($_GET['guia_id'])) {

            $paciente_id = $this->exametemp->listarpacienteporguia($_GET['guia_id']);

            $saldoCredito = $this->exametemp->listarsaldocreditopaciente($paciente_id);
        }

        echo json_encode(array("saldo" => $saldoCredito[0]->saldo, "paciente_id" => $paciente_id));
    }

    function conveniopaciente() {
        if (isset($_GET['txtNomeid'])) {
            $result = $this->exametemp->listarautocompleteconveniopaciente($_GET['txtNomeid']);
        } else {
            $result = $this->exametemp->listarautocompleteconveniopaciente();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos2() {

        if (isset($_GET['convenio2'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio2']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos3() {

        if (isset($_GET['convenio3'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio3']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos4() {

        if (isset($_GET['convenio4'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio4']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function classeportiposaidalista() {
        if (isset($_GET['nome'])) {
            $result = $this->financeiro_classe->listarautocompleteclassessaida($_GET['nome']);
        } else {
            $result = $this->financeiro_classe->listarautocompleteclassessaida();
        }
        echo json_encode($result);
    }

    function contaporempresa() {
        if (isset($_GET['empresa'])) {
            $result = $this->forma->listarautocompletecontaempresa($_GET['empresa']);
        } else {
            $result = $this->forma->listarautocompletecontaempresa();
        }
        echo json_encode($result);
    }

    function classeportiposaidalistadescricao() {
        if (isset($_GET['nome'])) {
            $result = $this->financeiro_classe->listarautocompleteclassessaidadescricao($_GET['nome']);
        } else {
            $result = $this->financeiro_classe->listarautocompleteclassessaidadescricao();
        }
        echo json_encode($result);
    }

    function classeportiposaidalistadescricaotodos() {
        if (isset($_GET['nome'])) {
            $result = $this->financeiro_classe->listarautocompleteclassessaidadescricaotodos($_GET['nome']);
        } else {
            $result = $this->financeiro_classe->listarautocompleteclassessaidadescricaotodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos5() {

        if (isset($_GET['convenio5'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio5']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos6() {

        if (isset($_GET['convenio6'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio6']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos7() {

        if (isset($_GET['convenio7'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio7']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos8() {

        if (isset($_GET['convenio8'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio8']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos9() {

        if (isset($_GET['convenio9'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio9']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos10() {

        if (isset($_GET['convenio10'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio10']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos11() {

        if (isset($_GET['convenio11'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio11']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos12() {

        if (isset($_GET['convenio12'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio12']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos13() {

        if (isset($_GET['convenio13'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio13']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos14() {

        if (isset($_GET['convenio14'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio14']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconveniotodos15() {

        if (isset($_GET['convenio15'])) {
            $result = $this->exametemp->listarautocompleteprocedimentostodos($_GET['convenio15']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentostodos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioajustarvalor() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosajustarvalor($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosajustarvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioatendimento() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosatendimento($_GET['convenio1'], $_GET['grupo']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosatendimento();
        }
        echo json_encode($result);
    }
    
    function procedimentoconvenioatendimentonovo() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosatendimentonovo($_GET['convenio1'], @$_GET['grupo']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosatendimentonovo();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioorcamento() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosorcamento($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosorcamento();
        }
        echo json_encode($result);
    }

    function procedimentoconveniofidelidadeweb() {
        header('Access-Control-Allow-Origin: *');
        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosfidelidadeweb($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosfidelidadeweb();
        }
        echo json_encode($result);
    }

    function procedimentoconveniofaturar() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosfaturar($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosfaturar();
        }
        echo json_encode($result);
    }

    function procedimentoconveniofaturarmatmed() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosfaturarmatmed($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosfaturarmatmed();
        }
        echo json_encode($result);
    }

    function conveniocarteira() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteconveniocarteira($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarautocompleteconveniocarteira();
        }
        echo json_encode($result);
    }

    function procedimentoconveniogrupoexame() {
//        var_dump($_GET);die;
        if (isset($_GET['convenio1']) && isset($_GET['grupo1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosgrupoexame($_GET['convenio1'], $_GET['grupo1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosgrupoexame(@$_GET['convenio1'], @$_GET['grupo1']);
        }
        echo json_encode($result);
    }

    function procedimentoconveniogrupoorcamento() {
//        var_dump($_GET);die;
        if (isset($_GET['convenio1']) && isset($_GET['grupo1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosgrupoorcamento($_GET['convenio1'], $_GET['grupo1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosgrupoorcamento(@$_GET['convenio1'], @$_GET['grupo1']);
        }
        echo json_encode($result);
    }

    function cadastroexcecaoprocedimentoconveniogrupo() {

        if (isset($_GET['convenio1']) && isset($_GET['grupo1'])) {
            $result = $this->exametemp->listarautocompletecadastroexcecaoprocedimentosgrupo($_GET['convenio1'], $_GET['grupo1']);
        } else {
            $result = $this->exametemp->listarautocompletecadastroexcecaoprocedimentosgrupo(@$_GET['convenio1'], @$_GET['grupo1']);
        }

        echo json_encode($result);
    }

    function procedimentoagrupadorgrupo() {

        $result = $this->exametemp->listarautocompleteprocedimentoagrupadorgrupo($_GET['grupo1']);

        echo json_encode($result);
    }

    function procedimentoconveniogrupo() {

        if (isset($_GET['convenio1']) && isset($_GET['grupo1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosgrupo($_GET['convenio1'], $_GET['grupo1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosgrupo(@$_GET['convenio1'], @$_GET['grupo1']);
        }

        echo json_encode($result);
    }

    function listargruposala() {
        if (isset($_GET['sala'])) {
            $result = $this->exametemp->listarautocompletegruposala($_GET['sala']);
        }

        echo json_encode($result);
    }

    function listarsalaporgrupo() {
        if (isset($_GET['grupo1'])) {
            $result = $this->exametemp->listarautocompletesalaporgrupo($_GET['grupo1']);
        }

        echo json_encode($result);
    }

    function listarmedicoprocedimentoconvenio() {
//        var_dump($_GET);die;
        if (isset($_GET['procedimento'])) {
            $result = $this->exametemp->listarautocompletemedicoporprocedimento($_GET['procedimento']);
        }

        echo json_encode($result);
    }

    function procedimentoconveniogrupomedico() {
//        var_dump($_GET);die;
        if (isset($_GET['convenio1']) && isset($_GET['grupo1']) && isset($_GET['teste'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosgrupomedico($_GET['convenio1'], $_GET['grupo1'], $_GET['teste']);
        }

        echo json_encode($result);
    }

    function procedimentoporconvenio() {

        if (isset($_GET['covenio'])) {
            $result = $this->procedimentoplano->listarautocompleteprocedimentos($_GET['covenio']);
        } else {
            $result = $this->procedimentoplano->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function estoqueclasseportipo() {

        if (isset($_GET['tipo_id'])) {
            $result = $this->menu->listarautocompleteclasseportipo($_GET['tipo_id']);
        } else {
            $result = $this->menu->listarautocompleteclasseportipo();
        }
        echo json_encode($result);
    }

    function estoquesubclasseporclasse() {

        if (isset($_GET['classe_id'])) {
            $result = $this->menu->listarautocompletesubclasseporclasse($_GET['classe_id']);
        } else {
            $result = $this->menu->listarautocompletesubclasseporclasse();
        }
        echo json_encode($result);
    }

    function estoqueprodutosporsubclasse() {

        if (isset($_GET['subclasse_id'])) {
            $result = $this->menu->listarautocompleteprodutosporsubclasse($_GET['subclasse_id']);
        } else {
            $result = $this->menu->listarautocompleteprodutosporsubclasse();
        }
        echo json_encode($result);
    }

    function formapagamentoorcamento() {
        $forma = $_GET['formapamento1'];
        if (isset($forma)) {
            $result = $this->formapagamento->buscarformapagamentoorcamento($forma);
        }
        echo json_encode($result);
    }

    function formapagamento($forma) {

        if (isset($forma)) {
            $result = $this->formapagamento->buscarforma($forma);
        } else {
            $result = $this->formapagamento->buscarforma();
        }
        echo json_encode($result);
    }

    function classeportipo() {

        if (isset($_GET['tipo'])) {
            $result = $this->financeiro_classe->listarautocompleteclasse($_GET['tipo']);
        } else {
            $result = $this->financeiro_classe->listarautocompleteclasse();
        }
        echo json_encode($result);
    }

    function classeportiposaida() {

        if (isset($_GET['tipo'])) {
            $result = $this->financeiro_classe->listarautocompleteclassessaida($_GET['tipo']);
        } else {
            $result = $this->financeiro_classe->listarautocompleteclassessaida();
        }
        echo json_encode($result);
    }

    function medicoconveniogeral() {

        if (isset($_GET['exame'])) {
            $result = $this->exametemp->listarautocompletemedicoconveniogeral($_GET['exame']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconveniogeral();
        }
//        echo "<pre>";
//        var_dump($result); die;
        echo json_encode($result);
    }

    function medicoconvenio() {

        if (isset($_GET['exame'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['exame']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio1() {

        if (isset($_GET['medico_id1'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id1']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio2() {

        if (isset($_GET['medico_id2'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id2']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio3() {

        if (isset($_GET['medico_id3'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id3']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio4() {

        if (isset($_GET['medico_id4'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id4']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio5() {

        if (isset($_GET['medico_id5'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id5']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio6() {

        if (isset($_GET['medico_id6'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id6']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio7() {

        if (isset($_GET['medico_id7'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id7']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio8() {

        if (isset($_GET['medico_id8'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id8']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio9() {

        if (isset($_GET['medico_id9'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id9']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio10() {

        if (isset($_GET['medico_id10'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id10']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio11() {

        if (isset($_GET['medico_id11'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id11']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio12() {

        if (isset($_GET['medico_id12'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id12']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio13() {

        if (isset($_GET['medico_id13'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id13']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio14() {

        if (isset($_GET['medico_id14'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id14']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function medicoconvenio15() {

        if (isset($_GET['medico_id15'])) {
            $result = $this->exametemp->listarautocompletemedicoconvenio($_GET['medico_id15']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoconvenio();
        }
        echo json_encode($result);
    }

    function procedimentoformapagamento() {

        if (isset($_GET['txtpagamento'])) {
            $result = $this->procedimentoplano->listarautocompleteformapagamento($_GET['txtpagamento']);
        } else {
            $result = $this->procedimentoplano->listarautocompleteformapagamento();
        }
//        var_dump($result); die;
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->forma_pagamento_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function procedimentoconveniomultiempresa() {
        header('Access-Control-Allow-Origin: *');
        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosmultiempresa($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosmultiempresa();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta() {
        header('Access-Control-Allow-Origin: *');
        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentoconveniofisioterapia() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosfisioterapia($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosfisioterapia();
        }
        echo json_encode($result);
    }

    function procedimentoconveniopsicologia() {

        if (isset($_GET['convenio1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentospsicologia($_GET['convenio1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentospsicologia();
        }
        echo json_encode($result);
    }

    function procedimentovalor() {

        if (isset($_GET['procedimento1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalororcamento() {
        if (isset($_GET['procedimento1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor2($_GET['procedimento1'], $_GET['convenio']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor2();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia() {

        if (isset($_GET['procedimento1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia2() {

        if (isset($_GET['procedimento2'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento2']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia3() {

        if (isset($_GET['procedimento3'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento3']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia4() {

        if (isset($_GET['procedimento4'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento4']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia5() {

        if (isset($_GET['procedimento5'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento5']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia6() {

        if (isset($_GET['procedimento6'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento6']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia7() {

        if (isset($_GET['procedimento7'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento7']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia8() {

        if (isset($_GET['procedimento8'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento8']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia9() {

        if (isset($_GET['procedimento9'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento9']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia10() {

        if (isset($_GET['procedimento10'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento10']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia11() {

        if (isset($_GET['procedimento11'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento11']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia12() {

        if (isset($_GET['procedimento12'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento12']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia13() {

        if (isset($_GET['procedimento13'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento13']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia14() {

        if (isset($_GET['procedimento14'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento14']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorfisioterapia15() {

        if (isset($_GET['procedimento15'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento15']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentovalorpsicologia() {

        if (isset($_GET['procedimento1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio2() {

        if (isset($_GET['convenio2'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio2']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta2() {

        if (isset($_GET['convenio2'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio2']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor2() {

        if (isset($_GET['procedimento2'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento2']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio3() {

        if (isset($_GET['convenio3'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio3']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta3() {

        if (isset($_GET['convenio3'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio3']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor3() {

        if (isset($_GET['procedimento3'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento3']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio4() {

        if (isset($_GET['convenio4'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio4']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta4() {

        if (isset($_GET['convenio4'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio4']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor4() {

        if (isset($_GET['procedimento4'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento4']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio5() {

        if (isset($_GET['convenio5'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio5']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta5() {

        if (isset($_GET['convenio5'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio5']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor5() {

        if (isset($_GET['procedimento5'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento5']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio6() {

        if (isset($_GET['convenio6'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio6']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta6() {

        if (isset($_GET['convenio6'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio6']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor6() {

        if (isset($_GET['procedimento6'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento6']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio7() {

        if (isset($_GET['convenio7'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio7']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta7() {

        if (isset($_GET['convenio7'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio7']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor7() {

        if (isset($_GET['procedimento7'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento7']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio8() {

        if (isset($_GET['convenio8'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio8']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta8() {

        if (isset($_GET['convenio8'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio8']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor8() {

        if (isset($_GET['procedimento8'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento8']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio9() {

        if (isset($_GET['convenio9'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio9']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta9() {

        if (isset($_GET['convenio9'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio9']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor9() {

        if (isset($_GET['procedimento9'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento9']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function procedimentoconvenio10() {

        if (isset($_GET['convenio10'])) {
            $result = $this->exametemp->listarautocompleteprocedimentos($_GET['convenio10']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentos();
        }
        echo json_encode($result);
    }

    function procedimentoconvenioconsulta10() {

        if (isset($_GET['convenio10'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta($_GET['convenio10']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosconsulta();
        }
        echo json_encode($result);
    }

    function procedimentovalor10() {

        if (isset($_GET['procedimento10'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor($_GET['procedimento10']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosvalor();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento1() {

        if (isset($_GET['procedimento1'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosforma($_GET['procedimento1']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento2() {

        if (isset($_GET['procedimento2'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosforma($_GET['procedimento2']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento3() {

        if (isset($_GET['procedimento3'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosforma($_GET['procedimento3']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento4() {

        if (isset($_GET['procedimento4'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosforma($_GET['procedimento4']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento5() {

        if (isset($_GET['procedimento5'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosforma($_GET['procedimento5']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento6() {

        if (isset($_GET['procedimento6'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosforma($_GET['procedimento6']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento7() {

        if (isset($_GET['procedimento7'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosforma($_GET['procedimento7']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento8() {

        if (isset($_GET['procedimento8'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosforma($_GET['procedimento8']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento9() {

        if (isset($_GET['procedimento9'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosforma($_GET['procedimento9']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosforma();
        }
        echo json_encode($result);
    }

    function formapagamentoporprocedimento10() {

        if (isset($_GET['procedimento10'])) {
            $result = $this->exametemp->listarautocompleteprocedimentosforma($_GET['procedimento10']);
        } else {
            $result = $this->exametemp->listarautocompleteprocedimentosforma();
        }
        echo json_encode($result);
    }

    function credordevedor() {

        if (isset($_GET['term'])) {
            $result = $this->contaspagar->listarautocompletecredro($_GET['term']);
        } else {
            $result = $this->contaspagar->listarautocompletecredro();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->razao_social;
            $retorno['id'] = $item->financeiro_credor_devedor_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function modeloslaudo() {

        if (isset($_GET['exame'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarautocompletemodelos($_GET['exame']);
        } else {
            $result = $this->exametemp->listarautocompletemodelos();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function modelosdeclaracao() {

        if (isset($_GET['modelo'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarautocompletemodelosdeclaracao($_GET['modelo']);
        } else {
            $result = $this->exametemp->listarautocompletemodelosdeclaracao();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function modelosreceita() {

        if (isset($_GET['exame'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarautocompletemodelosreceita($_GET['exame']);
        } else {
            $result = $this->exametemp->listarautocompletemodelosreceita();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function modelosatestado() {

        if (isset($_GET['exame'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarautocompletemodelosatestado($_GET['exame']);
        } else {
            $result = $this->exametemp->listarautocompletemodelosatestado();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function modelossolicitarexames() {

        if (isset($_GET['exame'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarautocompletemodelossolicitarexames($_GET['exame']);
        } else {
            $result = $this->exametemp->listarautocompletemodelossolicitarexames();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function medicamentounidade() {

        if (isset($_GET['unidade'])) {
            $result = $this->exametemp->listarautocompletemedicamentounidade($_GET['unidade']);
        } else {
            $result = $this->exametemp->listarautocompletemedicamentounidade();
        }
        foreach ($result as $item) {
            $retorno['id'] = $item->unidade_id;
            $retorno['value'] = $item->descricao;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function modelosreceitaespecial() {

        if (isset($_GET['exame'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarautocompletemodelosreceitaespecial($_GET['exame']);
        } else {
            $result = $this->exametemp->listarautocompletemodelosreceitaespecial();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function modeloslinhas() {

        if (isset($_GET['linha'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarautocompletelinha($_GET['linha']);
        } else {
            $result = $this->exametemp->listarautocompletelinha();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function medicoespecialidadetodos() {
        header('Access-Control-Allow-Origin: *');
        if (isset($_GET['txtcbo'])) {
            $result = $this->operador_m->listarmedicosespecialidade($_GET['txtcbo']);
        } else {
            $result = $this->operador_m->listarmedicosespecialidade();
        }


        echo json_encode($result);
    }

    function medicoespecialidade() {
        header('Access-Control-Allow-Origin: *');
        if (isset($_GET['txtcbo'])) {
            $result = $this->exametemp->listarautocompletemedicoespecialidade($_GET['txtcbo']);
        } else {
            $result = $this->exametemp->listarautocompletemedicoespecialidade();
        }


        echo json_encode($result);
    }

    function listarmedicotipoagenda() {
//        header('Access-Control-Allow-Origin: *');
        if (isset($_GET['tipoagenda'])) {
            $result = $this->exametemp->listarautocompletemedicotipoagenda($_GET['tipoagenda']);
        } else {
            $result = $this->exametemp->listarautocompletemedicotipoagenda();
        }

        echo json_encode($result);
    }

    function grupoempresa() {
//        header('Access-Control-Allow-Origin: *');
        if (isset($_GET['txtgrupo'])) {
            $result = $this->exametemp->listarautocompletegrupoempresa($_GET['txtgrupo']);
        } else {
            $result = $this->exametemp->listarautocompletegrupoempresa();
        }

        echo json_encode($result);
    }

    function agendaempresasala() {
        $result = array();
        if (isset($_GET['txtempresa'])) {
            $result = $this->exametemp->listarautocompleteagendaempresasala($_GET['txtempresa']);
        }

        echo json_encode($result);
    }

    function grupoempresasala() {
//        header('Access-Control-Allow-Origin: *');
        if (isset($_GET['txtgrupo'])) {
            $result = $this->exametemp->listarautocompletegrupoempresasala($_GET['txtgrupo'], $_GET['txtempresa']);
        } else {
            $result = $this->exametemp->listarautocompletegrupoempresasala();
        }

        echo json_encode($result);
    }

    function grupoempresasalatodos() {
//        header('Access-Control-Allow-Origin: *');
        if (isset($_GET['txtgrupo'])) {
            $result = $this->exametemp->listarautocompletegrupoempresasalatodos($_GET['txtgrupo'], $_GET['txtempresa']);
        } else {
            $result = $this->exametemp->listarautocompletegrupoempresasalatodos();
        }

        echo json_encode($result);
    }

    function cboprofissionaismultifuncao() {
        if (isset($_GET['term'])) {
            $result = $this->operador_m->listacboprofissionaisautocomplete($_GET['term']);
        } else {
            $result = $this->operador_m->listacboprofissionaisautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->descricao;
            $retorno['id'] = $item->cbo_ocupacao_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function linhas() {

        if (isset($_GET['term'])) {
            $result = $this->exametemp->listarautocompletelinha($_GET['term']);
        } else {
            $result = $this->exametemp->listarautocompletelinha();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome . '-' . $item->texto;
            $retorno['id'] = $item->texto;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function medicamentolaudo() {

        if (isset($_GET['term'])) {
            $result = $this->exametemp->listarautocompletemedicamentolaudo($_GET['term']);
        } else {
            $result = $this->exametemp->listarautocompletemedicamentolaudo();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome . ' (' . $item->quantidade . ' - ' . $item->descricao . ') -> ' . $item->posologia;
            $retorno['id'] = $item->texto . '<br>' . $item->posologia;
            $retorno['qtde'] = $item->quantidade;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function modeloslaudos() {

        if (isset($_GET['exame'])) {
            //$result = 'oi';
            $result = $this->exametemp->listarautocompletemodelos($_GET['exame']);
        } else {
            $result = $this->exametemp->listarautocompletemodelos();
            //$result = 'oi nao';
        }
        echo json_encode($result);
    }

    function laudosanteriores() {

        if (isset($_GET['anteriores'])) {

            $result = $this->laudo->listarautocompletelaudos($_GET['anteriores']);
        } else {
            $result = $this->laudo->listarautocompletelaudos();
        }
        echo json_encode($result);
    }

    function cidade() {

        if (isset($_GET['term'])) {
            $result = $this->paciente_m->listarCidades($_GET['term']);
        } else {
            $result = $this->paciente_m->listarCidades();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome . ' - ' . $item->estado;
            $retorno['id'] = $item->municipio_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function cidadeibge() {

        if (isset($_GET['ibge'])) {
            $result = $this->paciente_m->listarCidadesibge($_GET['ibge']);
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome . ' - ' . $item->estado;
            $retorno['id'] = $item->municipio_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function produto() {

        if (isset($_GET['term'])) {
            $result = $this->produto_m->autocompleteproduto($_GET['term']);
        } else {
            $result = $this->produto_m->autocompleteproduto();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->descricao;
            $retorno['id'] = $item->estoque_produto_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function fornecedor() {

        if (isset($_GET['term'])) {
            $result = $this->fornecedor_m->autocompletefornecedor($_GET['term']);
        } else {
            $result = $this->fornecedor_m->autocompletefornecedor();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->fantasia;
            $retorno['id'] = $item->estoque_fornecedor_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function procedimentotuss() {

        if (isset($_GET['term'])) {
            $result = $this->procedimento->listarautocompletetuss($_GET['term']);
        } else {
            $result = $this->procedimento->listarautocompletetuss();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->codigo . ' - ' . $item->descricao . ' - ' . $item->ans;
            $retorno['id'] = $item->tuss_id;
            $retorno['codigo'] = $item->codigo;
            $retorno['descricao'] = $item->descricao . ' - ' . $item->ans;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function procedimentotusspesquisa() {

        if (isset($_GET['term'])) {
            $result = $this->procedimento->listarautocompletetuss($_GET['term']);
        } else {
            $result = $this->procedimento->listarautocompletetuss();
        }
        foreach ($result as $item) {
            $retorno['value'] = "Código : " . $item->codigo . ' - Descrição :' . $item->descricao . ' - ' . $item->ans;
            $retorno['id'] = $item->tuss_id;
            $retorno['codigo'] = $item->codigo;
            $retorno['descricao'] = $item->descricao . ' - ' . $item->ans;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function cbo() {

        if (isset($_GET['term'])) {
            $result = $this->operador_m->listarcbo($_GET['term']);
        } else {
            $result = $this->operador_m->listarcbo();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->descricao;
            $retorno['id'] = $item->cbo_grupo_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function cargo() {
        if (isset($_GET['term'])) {
            $result = $this->cargo->listarautocomplete($_GET['term']);
        } else {
            $result = $this->cargo->listarautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->cargo_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function motivo_atendimento() {
        if (isset($_GET['term'])) {
            $result = $this->solicita_acolhimento_m->listamotivoautocomplete($_GET['term']);
        } else {
            $result = $this->solicita_acolhimento_m->listamotivoautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->emergencia_motivoatendimento_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function medicosaida() {
        if (isset($_GET['term'])) {
            $result = $this->solicita_acolhimento_m->listarmedicosaida($_GET['term']);
        } else {
            $result = $this->solicita_acolhimento_m->listarmedicosaida();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->conselho . '-' . $item->nome;
            $retorno['id'] = $item->operador_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function medicos() {
        if (isset($_GET['term'])) {
            $result = $this->guia->listarmedicos($_GET['term']);
        } else {
            $result = $this->guia->listarmedicos();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->conselho . '-' . $item->nome;
            $retorno['id'] = $item->operador_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function pacientes() {
        if (isset($_GET['term'])) {
            $result = $this->guia->listarpacientes($_GET['term']);
        } else {
            $result = $this->guia->listarpacientes();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->paciente_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function funcao() {
        if (isset($_GET['term'])) {
            $result = $this->funcao->listarautocomplete($_GET['term']);
        } else {
            $result = $this->funcao->listarautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->funcao_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function ocorrenciatipo() {
        if (isset($_GET['term'])) {
            $result = $this->ocorrenciatipo->listarautocomplete($_GET['term']);
        } else {
            $result = $this->ocorrenciatipo->listarautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->ocorrenciatipo_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function setor() {
        if (isset($_GET['term'])) {
            $result = $this->setor->listarautocomplete($_GET['term']);
        } else {
            $result = $this->setor->listarautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->setor_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function horariostipo() {
        if (isset($_GET['term'])) {
            $result = $this->horariostipo->listarautocomplete($_GET['term']);
        } else {
            $result = $this->horariostipo->listarautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->horariostipo_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function funcionario() {
        if (isset($_GET['term'])) {
            $result = $this->funcionario->listarautocomplete($_GET['term']);
        } else {
            $result = $this->funcionario->listarautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->funcionario_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function unidade() {
        if (isset($_GET['term'])) {
            $result = $this->unidade_m->listaunidadeautocomplete($_GET['term']);
        } else {
            $result = $this->unidade_m->listaunidadeautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['id'] = $item->internacao_unidade_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function operador() {
        if (isset($_GET['term'])) {
            $result = $this->operador_m->listaoperadorautocomplete($_GET['term']);
        } else {
            $result = $this->operador_m->listaoperadorautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->conselho . '-' . $item->nome;
            $retorno['id'] = $item->operador_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function cboprofissionais() {
        if (isset($_GET['term'])) {
            $result = $this->operador_m->listacboprofissionaisautocomplete($_GET['term']);
        } else {
            $result = $this->operador_m->listacboprofissionaisautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->cbo_ocupacao_id . '-' . $item->descricao;
            $retorno['id'] = $item->cbo_ocupacao_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function cep() {
        if (isset($_GET['term'])) {
            $cep = str_replace("-", "", $_GET['term']);
            $result = $this->paciente_m->cep($cep);
        } else {
            $result = $this->paciente_m->cep();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->cep . ' - ' . $item->tipo_logradouro . ' ' . $item->logradouro_nome;
            $retorno['cep'] = $item->cep;
            $retorno['logradouro_nome'] = $item->logradouro_nome;
            $retorno['tipo_logradouro'] = $item->tipo_logradouro;
            $retorno['localidade_nome'] = $item->localidade_nome;
            $retorno['nome_bairro'] = $item->nome_bairro;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function paciente() {
        header('Access-Control-Allow-Origin: *');
        if (isset($_GET['term'])) {
            $result = $this->exame->listarautocompletepaciente($_GET['term']);
        } else {
            $result = $this->exame->listarautocompletepaciente();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['itens'] = $item->telefone;
            $retorno['celular'] = $item->celular;
            $retorno['valor'] = substr($item->nascimento, 8, 2) . "/" . substr($item->nascimento, 5, 2) . "/" . substr($item->nascimento, 0, 4);
            $retorno['id'] = $item->paciente_id;
            $retorno['endereco'] = $item->logradouro . " - " . $item->numero;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function pacientecpf() {
        header('Access-Control-Allow-Origin: *');
        if (isset($_GET['term'])) {
            $result = $this->exame->listarautocompletepacientecpf($_GET['term']);
        } else {
            $result = $this->exame->listarautocompletepacientecpf();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['itens'] = $item->telefone;
            $retorno['celular'] = $item->celular;
            $retorno['valor'] = substr($item->nascimento, 8, 2) . "/" . substr($item->nascimento, 5, 2) . "/" . substr($item->nascimento, 0, 4);
            $retorno['id'] = $item->paciente_id;
            $retorno['endereco'] = $item->logradouro . " - " . $item->numero;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function pacienteunificar() {
        if (isset($_GET['term'])) {
            $result = $this->exame->listarautocompletepaciente($_GET['term']);
        } else {
            $result = $this->exame->listarautocompletepaciente();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->paciente_id . " - " . $item->nome;
            $retorno['itens'] = $item->telefone;
            $retorno['mae'] = $item->nome_mae;
            $retorno['valor'] = substr($item->nascimento, 8, 2) . "/" . substr($item->nascimento, 5, 2) . "/" . substr($item->nascimento, 0, 4);
            $retorno['id'] = $item->paciente_id;
            $retorno['endereco'] = $item->logradouro . " - " . $item->numero;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function operadorunificar() {
        if (isset($_GET['term'])) {
            $result = $this->operador_m->listaoperadorunificarautocomplete($_GET['term']);
        } else {
            $result = $this->operador_m->listaoperadorunificarautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['usuario'] = $item->usuario;
            $retorno['perfil'] = $item->perfil;
            $retorno['id'] = $item->operador_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function pacientenascimento() {
        $_GET['term'] = date("Y-m-d", strtotime(str_replace("/", "-", $_GET['term'])));
        if (isset($_GET['term'])) {
            $result = $this->exame->listarautocompletepacientenascimento($_GET['term']);
        } else {
            $result = $this->exame->listarautocompletepacientenascimento();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome;
            $retorno['itens'] = $item->telefone;
            $retorno['valor'] = substr($item->nascimento, 8, 2) . "/" . substr($item->nascimento, 5, 2) . "/" . substr($item->nascimento, 0, 4);
            $retorno['id'] = $item->paciente_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
//        echo json_encode('olaolaoa');
    }

    function cid1() {
        if (isset($_GET['term'])) {
            $result = $this->internacao_m->listacidautocomplete($_GET['term']);
        } else {
            $result = $this->internacao_m->listacidautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->co_cid . '-' . $item->no_cid;
            $retorno['id'] = $item->co_cid;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function cid2() {
        if (isset($_GET['term'])) {
            $result = $this->internacao_m->listacidautocomplete($_GET['term']);
        } else {
            $result = $this->internacao_m->listacidautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->co_cid . '-' . $item->no_cid;
            $retorno['id'] = $item->co_cid;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function procedimento() {
        if (isset($_GET['term'])) {
            $result = $this->internacao_m->listaprocedimentoautocomplete($_GET['term']);
        } else {
            $result = $this->internacao_m->listaprocedimentoautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->procedimento . '-' . $item->descricao;
            $retorno['id'] = $item->procedimento;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function enfermaria() {

        if (isset($_GET['term'])) {
            $result = $this->enfermaria_m->listaenfermariaautocomplete($_GET['term']);
        } else {
            $result = $this->enfermaria_m->listaenfermariaautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome . ' - ' . $item->unidade;
            $retorno['id'] = $item->internacao_enfermaria_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

    function leito() {

        if (isset($_GET['term'])) {
            $result = $this->leito_m->listaleitoautocomplete($_GET['term']);
        } else {
            $result = $this->leito_m->listaleitoautocomplete();
        }
        foreach ($result as $item) {
            $retorno['value'] = $item->nome . ' - ' . $item->enfermaria . ' - ' . $item->unidade;
            $retorno['id'] = $item->internacao_leito_id;
            $var[] = $retorno;
        }
        echo json_encode($var);
    }

}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
