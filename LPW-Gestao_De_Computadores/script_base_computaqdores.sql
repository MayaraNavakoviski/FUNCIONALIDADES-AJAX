-- Tabela cliente
CREATE TABLE cliente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(20),
    email VARCHAR(100)
);

-- Inserir alguns clientes padrão
INSERT INTO cliente (nome, telefone, email) VALUES
('Maria Exemplo', '11999999999', 'maria@exemplo.com'),
('João Exemplo', '11988888888', 'joao@exemplo.com'),
('Ana Exemplo', '11977777777', 'ana@exemplo.com');

-- Tabela tipo_servico
CREATE TABLE tipo_servico (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL
);

-- Inserir alguns tipos de serviço padrão
INSERT INTO tipo_servico (nome) VALUES 
('Formatação'),
('Troca de Peça'),
('Limpeza Interna'),
('Instalação de Software'),
('Atualização de Sistema');

-- Tabela ordem_servico (entidade principal)
CREATE TABLE ordem_servico (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao_problema TEXT NOT NULL,
    data_abertura DATETIME NOT NULL,
    prazo_estimado DATE NOT NULL,
    status ENUM('Aberta', 'Em andamento', 'Concluída', 'Cancelada') DEFAULT 'Aberta',
    id_cliente INT NOT NULL,
    id_tipo_servico INT NOT NULL,
    FOREIGN KEY (id_cliente) REFERENCES cliente(id),
    FOREIGN KEY (id_tipo_servico) REFERENCES tipo_servico(id)
);