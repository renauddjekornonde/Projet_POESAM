# Guide de Travail avec 😎Aladji Maurice Devops😎 – Déploiement & Sécurité (DevOps)

Bienvenue dans le projet **POESAM** 👋\
Ce guide vous accompagne pour bien collaborer avec moi 😌, responsable du **Déploiement, QA, Docker, et Sécurité**.

Mon but : **vous faire gagner du temps, éviter les bugs en prod, et garantir que tout fonctionne chez tout le monde, partout, sans surprise.**

---

## 🛠️ Outils à installer (une seule fois)

| Outil              | Lien de téléchargement                                                                           |
| ------------------ | ------------------------------------------------------------------------------------------------ |
| **Docker Desktop** | [https://www.docker.com/products/docker-desktop](https://www.docker.com/products/docker-desktop) |
| **VS Code**        | [https://code.visualstudio.com/](https://code.visualstudio.com/)                                 |
| **Git**            | [https://git-scm.com/](https://git-scm.com/)                                                     |

> 🎯 Vous n’avez **pas besoin d’installer PHP, MySQL ou Laravel manuellement**.\
> Tout est déjà préparé dans un conteneur Docker prêt à l’emploi.

---

## 🚀 Lancer le projet en local (avec Docker)

### Étapes (à faire une seule fois) :

```bash
# Cloner le projet
git clone https://github.com/yusuf9900/Projet_POESAM.git
cd Projet_POESAM

# Copier la configuration d’environnement et ne modifier rien au niveau du fichier .env 
cp .env.example .env 


# Démarrer les conteneurs Laravel + MySQL
docker-compose up -d --build

# Lancer les commandes Laravel
docker exec -it poesam-app bash
php artisan key:generate
php artisan migrate
```
