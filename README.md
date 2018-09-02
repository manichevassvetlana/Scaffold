<b>Installation Steps</b>

1. Require the Package

You can create your new Scaffold app with the following command:</br>
composer create-project --stability=dev websolutions/scaffold test

2. Add Google Credentials

Next make sure to create a Firestore project and add path to your credentials file to your .env file:</br>
<code>GOOGLE_APPLICATION_CREDENTIALS = "GCFSCredentials.json"</code></br>
To create a new Firestore project follow this quide: https://firebase.google.com/docs/firestore/quickstart</br>

You will also need to add Firebase credentials to your app.</br>

Add Firebase API key to your .env file:</br>
<code>FIREBASE_API_KEY = <i>YOUR_API_KEY</i></code></br>

Add Firebase credentials to your resource/assests/js/app.js file:</br>
<code>let config = {</code></br>
<code>apiKey: "<API_KEY>",</code></br>
<code>authDomain: "<PROJECT_ID>.firebaseapp.com",</code></br>
<code>databaseURL: "https://<DATABASE_NAME>.firebaseio.com",</code></br>
<code>projectId: "<PROJECT_ID>",</code></br>
<code>storageBucket: ".appspot.com",</code></br>
<code>messagingSenderId: "<SENDER_ID>",</code></br>
<code>};</code></br>

How to add Firebase to your app: https://firebase.google.com/docs/web/setup</br>

After you can run the following commands:</br>
<code>npm install</br>
npm run dev</br></code>

3. Run Seeders

Lastly, you can seed your Firestore project.</br>
To do this simply run:</br>
<code>php artisan db:seed</code>

Start up a local development server with php artisan serve. Visit http://localhost:8000/login and log into the system as admin with credentials:</br>
email: admin@admin.com</br>
password: 123456</br>
