import React, { useState, useEffect, useContext } from "react";
import { createStackNavigator } from "@react-navigation/stack";
import { useFocusEffect } from '@react-navigation/native';
import { Button, Text, TextInput, StyleSheet, TouchableOpacity, RefreshControl, ScrollView, View } from "react-native";
import { AuthContext } from "./AuthProvider";
import Card from '../components/Card';
import axios from 'axios';

const defaultTasks = [];

const Stack = createStackNavigator();

function Done() {

  const { user } = useContext(AuthContext);
  const [tasks, setTasks] = useState(defaultTasks);
  const [refreshing, setRefreshing] = useState(false);

  function pullTasks() {
    axios.defaults.headers.common['Authorization'] = `Bearer ${user.token}`;
    axios.get(`/api/dones/${user.id}`)
    .then(response => {
      console.log(response.data);
      setTasks(response.data);
      //console.log(tasks);
    })
    .catch(error => {
      console.log('ok'+error.response);
    })
  }

  const onRefresh = React.useCallback(() => {
    setRefreshing(true);
    //wait(2000).then(() => setRefreshing(false));
    console.log('refreshing');
    pullTasks();
    setRefreshing(false);
  }, []);

  useEffect(pullTasks, []);

  useFocusEffect(
    React.useCallback(() => {
      console.log('done screen was focused');
      // Do something when the screen is focused
      pullTasks();

      return () => {
        console.log('done Screen was unfocused');
        // Do something when the screen is unfocused
        // Useful for cleanup functions
      };
    }, [])
  );

  if (tasks.length > 0)
  return (
    <ScrollView refreshControl={
        <RefreshControl
          refreshing={refreshing}
          onRefresh={onRefresh}
        />
      }>
    <View style={styles.container}>
      {tasks.map((item) => (
        <Card key={item.id} style={styles.card}> 
          <Text style={styles.title}>{item.title}</Text>
          <Text style={styles.description}>{item.description}</Text>
          { item.client_notes ?
              <Text style={styles.client_notes}>{item.client_notes}</Text>
            :
              <Text style={{display:"none"}}>{item.client_notes}</Text>
          }
        </Card>
      ))}

      {/*<Card style={styles.card}> 
        <Text style={styles.title}>Moj treci card task</Text>
        <Text style={styles.description}>Treci card task ima isto malo duzi description koji prelazi u dva reda, a mozda i tri, cetiri. Za promenu.</Text>
        <TextInput style={{ color: 'gray', borderColor: '#c1d1c1', padding: 10, borderWidth: 1}}
        defaultValue="My notes..."
        />

        <Pressable
          onPress={() => {
            Alert.alert('Complete is yet to be completed.');
          }}
          style={styles.buttonRectangle}>
          {({ pressed }) => (
            <Text style={styles.buttonText}>
              COMPLETE
            </Text>
          )}
        </Pressable>

      </Card>*/}
    </View>
    </ScrollView>
  );
  else
    return (
      <ScrollView refreshControl={
        <RefreshControl
          refreshing={refreshing}
          onRefresh={onRefresh}
        />
      }>
        <View style={{flex: 1, alignItems: "center", justifyContent: "center"}}>
          <Text>No tasks at the moment.</Text>
        </View>
      </ScrollView>
    );
}

export const DoneStack = () => {
  const { logout } = useContext(AuthContext);
  return (
    <Stack.Navigator initialRouteName="Done">
      <Stack.Screen 
        name="Gopsi" 
        options={{
          headerRight: () => {
            return (
              <TouchableOpacity
                onPress={() => {
                  logout();
                }}
              >
                <Text style={{ color: 'gray', margin: 16 }}>Logout</Text>
              </TouchableOpacity>
            );
          }
        }}
      component={Done} />
    </Stack.Navigator>
  );
};

const styles = StyleSheet.create({
  card: {
      shadowColor: 'red',
      shadowOpacity: 0.26,
      shadowOffset: { width: 0, height: 2 },
      shadowRadius: 8,
      elevation: 5,
      borderRadius: 10,
      margin:5,
      minHeight: 20,
      width: '90%',
      backgroundColor: '#f1f3f5'
  },
  container: {
    flex: 1,
    paddingTop: 20,
    alignItems: 'center',
    justifyContent: 'flex-start',
  },
  title: {
    fontSize: 18,
    fontWeight: 'bold',
    padding: 10,
    color: '#656065',
  },
  buttonRectangle: {
    borderRadius: 8,
    padding: 1,
    margin: 4,
    backgroundColor: '#91c49f'
  },
  description: {
    fontSize: 16,
    fontWeight: 'normal',
    padding: 10,
    color: '#565656',
  },
  buttonText: {
    fontSize: 16,
    fontWeight: 'normal',
    padding: 5,
    textAlign: 'center',
    color: '#f5f7f5',
  },
  client_notes: {
    fontSize: 14,
    fontWeight: 'normal',
    padding: 10,
    color: '#56a656',
  },
  separator: {
    marginVertical: 30,
    height: 1,
    width: '80%',
  },
});