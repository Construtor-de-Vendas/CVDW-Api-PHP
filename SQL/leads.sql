CREATE TABLE
    `leads` (
        `numero` int NOT NULL,
        `idsituacao` int DEFAULT NULL,
        `situacao` varchar(80) DEFAULT NULL,
        `data_cad` datetime DEFAULT NULL,
        `nome` varchar(80) DEFAULT NULL,
        `email` varchar(80) DEFAULT NULL,
        `telefone` varchar(80) DEFAULT NULL,
        `documento_cliente` int DEFAULT NULL,
        `cep_cliente` varchar(30) DEFAULT NULL,
        `idponto_venda` int DEFAULT NULL,
        `ponto_venda` varchar(80) DEFAULT NULL,
        `conversao_original` varchar(80) DEFAULT NULL,
        `conversao_ultimo` varchar(80) DEFAULT NULL,
        `conversao` varchar(80) DEFAULT NULL,
        `idempreendimento` int DEFAULT NULL,
        `codigointerno_empreendimento` int DEFAULT NULL,
        `empreendimento` varchar(80) DEFAULT NULL,
        `idempreendimento_primeiro` int DEFAULT NULL,
        `empreendimento_primeiro` varchar(80) DEFAULT NULL,
        `idempreendimento_ultimo` int DEFAULT NULL,
        `empreendimento_ultimo` varchar(80) DEFAULT NULL,
        `idmotivo` int DEFAULT NULL,
        `motivo` varchar(80) DEFAULT NULL,
        `reserva` int DEFAULT NULL,
        `idgestor` int DEFAULT NULL,
        `gestor` varchar(80) DEFAULT NULL,
        `idcorretor` int DEFAULT NULL,
        `corretor` varchar(80) DEFAULT NULL,
        `idimobiliaria` int DEFAULT NULL,
        `imobiliaria` varchar(80) DEFAULT NULL,
        `caracteristicas` varchar(80) DEFAULT NULL,
        `feedback` varchar(80) DEFAULT NULL,
        `origem` varchar(80) DEFAULT NULL,
        `origem_ultimo` varchar(80) DEFAULT NULL,
        `midia_original` varchar(80) DEFAULT NULL,
        `midia_ultimo` varchar(80) DEFAULT NULL,
        `renda_familiar` varchar(80) DEFAULT NULL,
        `motivo_cancelamento` varchar(80) DEFAULT NULL,
        `data_cancelamento` datetime DEFAULT NULL,
        `data_ultima_alteracao` datetime DEFAULT NULL,
        `data_ultima_interacao` datetime DEFAULT NULL,
        `ultima_data_conversao` datetime DEFAULT NULL,
        `data_reativacao` datetime DEFAULT NULL,
        `idsituacao_anterior` int DEFAULT NULL,
        `nome_situacao_anterior_lead` varchar(80) DEFAULT NULL,
        `tags` varchar(80) DEFAULT NULL,
        `descricao_motivo_cancelamento` varchar(80) DEFAULT NULL,
        `possibilidade_venda` int DEFAULT NULL,
        `inserido_bolsao` varchar(80) DEFAULT NULL,
        `data_primeira_interacao_gestor` varchar(80) DEFAULT NULL,
        `data_primeira_interacao_corretor` datetime DEFAULT NULL,
        `score` int DEFAULT NULL,
        `idgestor_ultimo` int DEFAULT NULL,
        `gestor_ultimo` varchar(80) DEFAULT NULL,
        `idcorretor_ultimo` int DEFAULT NULL,
        `corretor_ultimo` varchar(80) DEFAULT NULL,
        `idcorretor_penultimo` int DEFAULT NULL,
        `corretor_penultimo` varchar(80) DEFAULT NULL,
        `data_ult_hist` datetime DEFAULT NULL,
        `nome_momento_lead` varchar(80) DEFAULT NULL,
        `novo` varchar(1) DEFAULT NULL,
        `retorno` varchar(1) DEFAULT NULL,
        `idorigem` int DEFAULT NULL,
        `idorigem_ultimo` int DEFAULT NULL,
        `origem_nome` varchar(80) DEFAULT NULL,
        `origem_ultimo_nome` varchar(80) DEFAULT NULL,
        PRIMARY KEY (`numero`)
    );