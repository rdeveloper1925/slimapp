

import 'firebase/compat/auth';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import AuthGuard from './Utils/AuthGuard';
import LoginPage from './Pages/LoginPage';
import { useEffect } from 'react';

function App() {
    

  return (
    <BrowserRouter>
    <Routes>
			<Route path="/" element={<LoginPage />} />
			<Route path="/home" element={<AuthGuard><App /></AuthGuard>}/>
		</Routes>
    </BrowserRouter>
  )
}

export default App
