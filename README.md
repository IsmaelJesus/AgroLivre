
# 🌱 AgroLivre

**AgroLivre** é um sistema de gerenciamento agrário desenvolvido como software livre. Seu objetivo é facilitar o controle de atividades agrícolas, oferecendo uma solução acessível, prática e adaptável à realidade do campo.

---

## 🚀 Instalação

### Pré-requisitos

- [Git](https://git-scm.com/)
- [Herd para Windows](https://herd.laravel.com/windows)

---

### 1. Instale o Herd

Baixe e instale o **Herd** através do link abaixo:

🔗 [https://herd.laravel.com/windows](https://herd.laravel.com/windows)

---

### 2. Acesse a pasta do Herd

Abra o **Explorador de Arquivos** do Windows e cole o caminho abaixo na barra de endereços:

```
%USERPROFILE%\Herd
```

---

### 3. Clone o repositório

No terminal, dentro da pasta `Herd`, execute o seguinte comando:

```bash
git clone git@github.com:IsmaelJesus/AgroLivre.git
```

> Certifique-se de que o Git esteja instalado e autenticado com sua conta 

---

### 4. Execute o Herd

Abra o aplicativo **Herd**. 

---

### 5. Acesse no navegador

Com o Herd em execução, abra o navegador e digite:

```
http://agrolivre.test
```

---

## 🧰 Configuração adicional (opcional)

Caso necessário, execute os seguintes comandos dentro do diretório do projeto:

```bash
cd AgroLivre
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
```

---

## 📄 Licença

Este projeto é de código aberto, distribuído sob a [Licença MIT](LICENSE).

---

## 👨‍🌾 Desenvolvedor

Desenvolvido por **Ismael Ramos**  
📧 ismael.vhs@gmail.com  
🌐 [github.com/IsmaelJesus](https://github.com/IsmaelJesus)
