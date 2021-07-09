import React, { useState, useEffect, useContext } from "react";
import { StyleSheet, Text, View, Button, TextInput, ActivityIndicator } from 'react-native';
import AsyncStorage from '@react-native-async-storage/async-storage';
import { NavigationContainer } from '@react-navigation/native';
import { AuthContext } from './AuthProvider';
import { AuthStack } from './AuthStack';
import { AppTabs } from "./AppTabs";
//import * as SecureStore from 'expo-secure-store';

export default function Routes() {
  const { user, setUser, login, logout } = useContext(AuthContext)
  const [loading, setLoading] = useState(true);

  const getAsyncUser = async () => {
    try {
      const userString = await AsyncStorage.getItem('user')
      if (userString !== null) {
        // value previously stored
        console.log("reading sonny: " + userString);
        userObject = JSON.parse(userString)
        setUser(userObject);
        return;
      }
    } catch(e) {
      // error reading value
      console.log("reading error sonny");
    }
  }

  useEffect(() => {
    // check if the user is logged in or not

    getAsyncUser();
    setLoading(false);
    console.log("ucitasmo usera");

    /*SecureStore.getItemAsync('user')
      .then(userString => {
        if (userString) {
          // decode it
          // login();
          userObject = JSON.parse(userString)
          setUser(userObject);
        }
        setLoading(false);
      })
      .catch(err => {
        console.log(err);
      })*/
  }, []);

  if (loading) {
    return (
      <View style={{ flex: 1, alignItems: 'center', justifyContent: 'center' }}>
        <ActivityIndicator size="large" />
      </View>
    )
  }

  return (
    <NavigationContainer>
      {user ? <AppTabs /> : <AuthStack />}
    </NavigationContainer>
  );
}
