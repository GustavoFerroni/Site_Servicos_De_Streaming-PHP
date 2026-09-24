CREATE DATABASE IF NOT EXISTS saas_tracker
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE saas_tracker;

CREATE TABLE assinaturas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    valor DECIMAL(10,2) NOT NULL,
    vencimento DATE NOT NULL,
    forma_pagamento VARCHAR(50) NOT NULL,
    status ENUM('ativo', 'cancelado') NOT NULL DEFAULT 'ativo'
);

-- Alguns registros de exemplo (opcional, pode apagar se não quiser)
INSERT INTO assinaturas (nome, categoria, valor, vencimento, forma_pagamento, status) VALUES
('Netflix', 'Streaming', 39.90, '2026-10-15', 'Cartão de crédito', 'ativo'),
('Spotify', 'Música', 21.90, '2026-10-05', 'Pix', 'ativo'),
('Hospedagem Hostinger', 'Hospedagem', 15.00, '2026-10-20', 'Boleto', 'cancelado');
