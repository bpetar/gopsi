import React, { useState } from 'react';
import AsyncStorage from '@react-native-async-storage/async-storage';
import axios from 'axios';

axios.defaults.baseURL = 'https://gopsi.mystic-peanut.com';
//axios.defaults.baseURL = 'http://192.168.0.162:8000/';

export const AuthContext = React.createContext({});

export const AuthProvider = ({children}) => {


  const [user, setUser] = useState(null);
  const [error, setError] = useState(null);

  const storeUserData = async (value) => {
  try {
    await AsyncStorage.setItem('user', value)
  } catch (e) {
    // saving error
    console.log("saving error sonny");
  }
}

  return (
    <AuthContext.Provider
      value={{
        user,
        setUser,
        error,
        login: (email, password) => {
          axios.post('/api/airlock/token', {
            email,
            password,
            device_name: 'mobile',
          })
          .then(response => {
            const userResponse = {
              email: response.data.user.email,
              token: response.data.token,
              id: response.data.user.id,
            }
            console.log(userResponse);
            setUser(userResponse);
            setError(null);
            storeUserData(JSON.stringify(userResponse))

            //SecureStore.setItemAsync('user', JSON.stringify(userResponse));
          })
          .catch(error => {
            console.log('pera login');
            console.log(error);
            const key = Object.keys(error.response.data.errors)[0];
            setError(error.response.data.errors[key][0]);
          })
        },
        register: (name, email, password) => {
          axios.post('/api/users', {
            name,
            email,
            password,
            device_name: 'mobile',
          })
          .then(response => {
            const userResponse = {
              email: response.data.user.email,
              token: response.data.token,
              id: response.data.user.id,
            }
            console.log(userResponse);
            setUser(userResponse);
            setError(null);
            storeUserData(JSON.stringify(userResponse))

            //SecureStore.setItemAsync('user', JSON.stringify(userResponse));
          })
          .catch(error => {
            console.log('pera');
            console.log(error);
            const key = Object.keys(error.response.data.errors)[0];
            setError(error.response.data.errors[key][0]);
          })
        },
        logout: () => {
          axios.defaults.headers.common['Authorization'] = `Bearer ${user.token}`;

          axios.post('/api/logout')
          .then(response => {
            setUser(null);
            // TODO add delete storage
            //SecureStore.deleteItemAsync('user')
          })
          .catch(error => {
            console.log(error.response);
            setUser(null);
          })
        }
      }}>
      {children}
    </AuthContext.Provider>
  );
}
