import { initializeApp } from "firebase/app";
import { getAuth, onAuthStateChanged } from "firebase/auth";
import { FirebaseAuth } from "react-firebaseui";
import firebase from "firebase/compat/app";
import "firebase/compat/auth";

type LoginProps = {
    message? : string | null
}

const LoginPage = (props:LoginProps) => {
	const firebaseConfig = {
		apiKey: import.meta.env.VITE_FIREBASE_API_KEY,
		authDomain: import.meta.env.VITE_FIREBASE_AUTHDOMAIN,
		projectId: import.meta.env.VITE_FIREBASE_PROJECTID,
		storageBucket: import.meta.env.VITE_FIREBASE_STORAGE_BUCKET,
		messagingSenderId: import.meta.env.VITE_FIREBASE_MESSEGING_SENDER,
		appId: import.meta.env.VITE_FIREBASE_APPID,
	};

	//initialize app
	const app = initializeApp(firebaseConfig);
	const auth = getAuth(app);

	//auth configs
	const uiConfig = {
		signInFlow: "popup",
		signInOptions: [
			firebase.auth.GoogleAuthProvider.PROVIDER_ID,
			firebase.auth.EmailAuthProvider.PROVIDER_ID,
		],
		callbacks: {
			// Avoid redirects after sign-in.
			signInSuccessWithAuthResult: (authResult) => {
				console.log(authResult, "authResult");
				//set global auth here,
                //onauthstate change subscribe.
                onAuthStateChanged(auth,(user)=>{
                    console.log(user, 'user');
                })

			},
			uiShown: function () {
				console.log("ui shown");
			},
		},
		// Terms of service url.
		tosUrl: "https://mattrodney.ca",
		// Privacy policy url.
		privacyPolicyUrl: "https://mattrodney.ca",
	};

    const showError = ()=>{
        if(props.message){
            return (<small>Error: {props.message}</small>)
        }else{
            return
        }
    }

    return (
    <>
      <div>
      <h1>My App</h1>
      {showError()}
      <p>Please sign-in:</p>
      <FirebaseAuth  uiConfig={uiConfig} firebaseAuth={auth} />
    </div>
    </>
  )
};

export default LoginPage;
