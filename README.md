<b>Installation Steps</b>

1. <strong>Require the Package</strong>

You can create your new Scaffold app with the following command:</br>
<code>composer create-project websolutions/scaffold test</code>

2. <strong>Add Google Credentials</strong>

Next make sure to create a Firestore project and add path to file with your service account credentials to .env file:</br>

<code>GOOGLE_APPLICATION_CREDENTIALS = "GCFSCredentials.json"</code></br>

To get started with Cloud Firestore:</br>
<i>1. Create a Cloud Firestore project</i></br>
-> Open the <a href="https://console.firebase.google.com/u/0/">Firebase Console</a> and create a new project.</br>
-> In the Database section, click the Get Started button for Cloud Firestore.</br>
-> Select a starting mode for your Cloud Firestore Security Rules - <b>Locked mode</b>.</br>
-> Click Enable.</br>
<i>2. Set up your development environment</i></br>
To authenticate from your development environment, set the <code>GOOGLE_APPLICATION_CREDENTIALS</code> environment variable to point to a JSON service account key file. You can create a key file on the <a href="https://console.cloud.google.com/apis/credentials/serviceaccountkey">API Console</a> Credentials page after setting up a service account. Download the key file to your project and public folders.

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

Add Firebase to your app</br>
<i>1. Select your Firebase project from the <a href="https://console.firebase.google.com">console</a>.</i></br>
To add Firebase to your app, you'll need a Firebase project and a short snippet of initialization code that has a few details about your project.
<i>2. From the project overview page in the Firebase console, click <b>Add Firebase to your web app</b>. </i></br>
<i>3. Set up your development environment</i></br>
Copy and paste your project's customized code snippet to your resource/assests/js/app.js file of your app and add <code>FIREBASE_API_KEY</code> to your .env file.</br>
<i>4. Dont forget to enable Firebase Authentication via email and password.</i> </br>
You can do this from the project overview page in the <a href="https://console.firebase.google.com">Firebase console</a>

After you can run npm following commands:</br>
<code>npm install</code></br>
<code>npm run dev</code></br>

3. <strong>Run Seeders</strong>

Lastly, you can seed your Firestore project.</br>
To do this simply run:</br>
<code>php artisan db:seed</code>

Start up a local development server with php artisan serve. Visit http://localhost:8000/login and log into the system as admin with credentials:</br>
email: admin@admin.com</br>
password: 123456</br>
