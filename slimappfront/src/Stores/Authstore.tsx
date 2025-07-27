import { create } from 'zustand';

export type User={
    uid: string,
    email: string,
    displayName?: string | null,
    photoURL?: string | null,
    providerId?: string| null
}

const emptyUser: User = {
    uid: '',
    email: '',
    displayName: null,
    photoURL: null,
    providerId: null,
} 

export const useAuthStore = create((set)=>
    ({
        user: emptyUser,
        setUser: (user: User)=>set({user}),
        clearUser: () => set(emptyUser)
    }));
