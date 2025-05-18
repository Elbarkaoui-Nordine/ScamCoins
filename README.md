# 🚀 La Factory — Exercice Technique : CoinMarketCap Clone

L’objectif de cet exercice est de développer une interface affichant les cryptomonnaies, à la manière de [CoinMarketCap](https://coinmarketcap.com/).  
Chaque cryptomonnaie doit pouvoir être cliquée pour afficher une **vue détaillée** contenant ses informations clés.

## 🧱 Stack Technique

Ce projet utilise la stack **TALL** :

- [Laravel](https://laravel.com/)
- [Livewire](https://laravel-livewire.com/)
- [Alpine.js](https://alpinejs.dev/)
- [Tailwind CSS](https://tailwindcss.com/)

## 🔌 API utilisée

Toutes les données (prix, logo, capitalisation, volume, etc.) sont récupérées depuis l'API publique de **CoinGecko** :  
📄 [Documentation officielle](https://www.coingecko.com/en/api/documentation)

## ⚙️ Configuration `.env`

Ajoutez ces variables dans votre fichier `.env` :

```env
COINGEKO_API_URL=https://api.coingecko.com/api/v3
COINGEKO_API_KEY=
****
