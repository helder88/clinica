--09/01/2018


CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_perfil WHERE nome = 'GERENTE DE RECEPÇÃO FINANCEIRO');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_perfil(perfil_id, nome)
        VALUES (18, 'GERENTE DE RECEPÇÃO FINANCEIRO');
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;

SELECT insereValor();


CREATE TABLE ponto.tb_empresa_impressao_encaminhamento
(
  empresa_impressao_encaminhamento_id serial,
  texto text,
  nome text,
  cabecalho boolean DEFAULT false,
  rodape boolean DEFAULT false,
  ativo boolean DEFAULT true,
  empresa_id integer,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_empresa_impressao_encaminhamento_pkey PRIMARY KEY (empresa_impressao_encaminhamento_id)
);


ALTER TABLE ponto.tb_empresa_permissoes ADD COLUMN encaminhamento_citycor boolean DEFAULT false;

--10/01/2018
CREATE TABLE ponto.tb_procedimento_percentual_laboratorio
(
  procedimento_percentual_laboratorio_id serial,
  procedimento_tuss_id integer,
  laboratorio integer,
  valor numeric(10,2),
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  CONSTRAINT tb_procedimento_percentual_laboratorio_pkey PRIMARY KEY (procedimento_percentual_laboratorio_id)
);


CREATE TABLE ponto.tb_procedimento_percentual_laboratorio_convenio
(
  procedimento_percentual_laboratorio_convenio_id serial,
  procedimento_percentual_laboratorio_id integer,
  laboratorio integer,
  valor numeric(10,2),
  percentual boolean DEFAULT true,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  dia_recebimento integer,
  tempo_recebimento integer,
  revisor boolean DEFAULT false,
  CONSTRAINT tb_procedimento_percentual_laboratorio_convenio_pkey PRIMARY KEY (procedimento_percentual_laboratorio_convenio_id)
);


CREATE TABLE ponto.tb_procedimento_percentual_laboratorio_convenio_antigo
(
  procedimento_percentual_laboratorio_convenio_antigo_id serial,
  procedimento_percentual_laboratorio_convenio_id integer,
  procedimento_percentual_laboratorio_id integer,
  laboratorio integer,
  valor numeric(10,2),
  percentual boolean DEFAULT true,
  ativo boolean DEFAULT true,
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  dia_recebimento integer,
  tempo_recebimento integer,
  CONSTRAINT tb_procedimento_percentual_laboratorio_convenio_antigo_pkey PRIMARY KEY (procedimento_percentual_laboratorio_convenio_antigo_id)
);



ALTER TABLE ponto.tb_procedimento_tuss ADD COLUMN valor_laboratorio numeric(10,2);
ALTER TABLE ponto.tb_procedimento_tuss ADD COLUMN percentual_laboratorio boolean DEFAULT false;

ALTER TABLE ponto.tb_empresa_impressao_laudo ADD COLUMN adicional_cabecalho text;



CREATE TABLE ponto.tb_laboratorio
(
  laboratorio_id serial NOT NULL,
  nome character varying(200),
  data_cadastro timestamp without time zone,
  operador_cadastro integer,
  data_atualizacao timestamp without time zone,
  operador_atualizacao integer,
  ativo boolean DEFAULT true,
  razao_social character varying(200),
  cnpj character varying(20),
  cep character varying(9),
  logradouro character varying(200),
  numero character varying(20),
  complemento character varying(100),
  bairro character varying(100),
  municipio_id integer,
  celular character varying(15),
  telefone character varying(15),
  tipo_logradouro_id integer,
  observacao character varying(2000),
  dinheiro boolean DEFAULT false,
  procedimento1 character varying(15),
  procedimento2 character varying(15),
  tabela character varying(30),
  credor_devedor_id integer,
  conta_id integer,
  enteral numeric(10,2),
  parenteral numeric(10,2),
  entrega integer,
  pagamento integer,
  ir numeric,
  pis numeric,
  cofins numeric,
  csll numeric,
  iss numeric,
  valor_base numeric,
  registroans character varying(11),
  codigoidentificador character varying(20),
  laboratorio_grupo_id integer,
  carteira_obrigatoria boolean DEFAULT false,
  home_care boolean DEFAULT false,
  associado boolean DEFAULT false,
  associacao_percentual numeric(10,4),
  associacao_laboratorio_id integer,
  data_percentual_atualizacao timestamp without time zone,
  operador_percentual_atualizacao integer,
  fidelidade_parceiro_id integer,
  fidelidade_endereco_ip text,
  CONSTRAINT tb_laboratorio_pkey PRIMARY KEY (laboratorio_id)
);



CREATE OR REPLACE FUNCTION insereValor()
RETURNS text AS $$
DECLARE
    resultado integer;
BEGIN
    resultado := ( SELECT COUNT(*) FROM ponto.tb_versao WHERE sistema = '1.0.000014');
    IF resultado = 0 THEN 
	INSERT INTO ponto.tb_versao(sistema, banco_de_dados)
        VALUES ('1.0.000014', '1.0.000014');
    END IF;
    RETURN 'SUCESSO';
END;
$$ LANGUAGE plpgsql;

SELECT insereValor();


 ALTER TABLE ponto.tb_agenda_exames ADD COLUMN valor_laboratorio numeric(10,2);
 ALTER TABLE ponto.tb_agenda_exames ADD COLUMN percentual_laboratorio boolean DEFAULT false;