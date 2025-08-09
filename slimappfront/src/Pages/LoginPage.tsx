import { initializeApp } from "firebase/app";
import { getAuth, onAuthStateChanged } from "firebase/auth";
import { FirebaseAuth } from "react-firebaseui";
import firebase from "firebase/compat/app";
import "firebase/compat/auth";
//import { User } from "../Stores/Authstore";
import { useAuthStore } from "../Stores/Authstore";
import axios, { AxiosError } from "axios";
import { Navigate, useNavigate } from "react-router-dom";
import { useEffect } from "react";

type LoginProps = {
	message?: string | null;
};

const LoginPage = (props: LoginProps) => {
	const setUser = useAuthStore((state) => state.setUser);
	const setLoggedIn = useAuthStore((state) => state.setLoggedIn);
	const isLoggedIn = useAuthStore((state) => state.isLoggedIn);
	const userz = useAuthStore((state) => state.user);
	const navigate = useNavigate();
    

    useEffect(()=>{
        if(isLoggedIn){
            navigate('/home');
        }
    },[]);

	const baseUrl = import.meta.env.VITE_BACKEND_BASE_URL;

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
				const user: User = {};
				user["uid"] = authResult.user.uid;
				user["email"] = authResult.user.email;
				user["name"] = authResult.user.displayName;
				user["providerId"] = authResult.user.providerData[0].providerId;
				user["photo"] = authResult.user.providerData[0].photoURL;
				console.log("user", user);
				axios
					.post(baseUrl + "api/login", user)
					.then((response) => {
						console.log("response user login", response);
						setUser(user);
						setLoggedIn(true);
						console.log("afterset", isLoggedIn, userz);
						navigate("/home");
					})
					.catch((error: AxiosError) => {
						console.log("error", error);
						console.log("reason", error.response.data.errors);
					});
				//set global auth here,
				//onauthstate change subscribe.
				onAuthStateChanged(auth, (user) => {
					console.log(user, "user");
				});
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

	const showError = () => {
		if (props.message) {
			return <small>Error: {props.message}</small>;
		} else {
			return;
		}
	};

	const showLogin = () => {
		if (isLoggedIn) {
			return <div>dude, you are loggedn in</div>;
		} else {
			return (
				<div
					style={{
						height: "100vh",
						display: "flex",
						justifyContent: "center",
					}}
				>
					<div className="d-flex justify-content-center align-items-center">
						<div className="shadow shadow-md border border-2 rounded rounded-4 card text-center">
							<div className="card-header">Featured</div>
							<div className="card-body">
								<h5 className="card-title">
									Login/Sign up here to continue
								</h5>
								<div className="card-text">
									<FirebaseAuth
										uiConfig={uiConfig}
										firebaseAuth={auth}
									/>
								</div>
							</div>
						</div>
					</div>
				</div>
			);
		}
	};

	return showLogin();
};

export default LoginPage;
