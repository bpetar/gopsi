import React, { useContext, useRef, useState, useEffect } from "react";
import { createStackNavigator } from "@react-navigation/stack";
import { Center } from "./Center";
import { Text, TouchableOpacity, FlatList, Button, StyleSheet, TextInput, ScrollView, View, Pressable, Alert } from "react-native";
import { AuthContext } from "./AuthProvider";
import { HomeParamList, HomeStackNavProps } from "./HomeParamList";
import Card from '../components/Card';
import axios from 'axios';

interface HomeStackProps {}
type User = null | { email: string, token: string, id: number };
type Task = null | { name: string, description: string, id: number };
const defaultTasks: Task[] = [];

const Stack = createStackNavigator<HomeParamList>();

function Feed({ navigation }: HomeStackNavProps<"Feed">) {
  const { user } = useContext(AuthContext);
  const [tasks, setTasks] = useState<Task[]>(defaultTasks);

  useEffect(() => {
    axios.defaults.headers.common['Authorization'] = `Bearer ${user.token}`;
    axios.get(`/api/tasks/${user.id}`)
    .then(response => {
      console.log(response.data);
      setTasks(response.data);
      console.log(tasks);
    })
    .catch(error => {
      console.log('ok'+error.response);
    })
  }, []);

  if (tasks.length > 0)
    return (
      <ScrollView>
      <View style={styles.container}>
        {tasks.map((item) => (
          <Card key={item.id} style={styles.card}> 
            <Text style={styles.title}>{item.title}</Text>
            <Text style={styles.description}>{item.description}</Text>
            <TextInput style={{color: 'gray', borderColor: '#c1d1c1', padding: 10, borderWidth: 1}}
            defaultValue="My notes..."
            />
            <Button color="#91c49f" title="Complete" 
              onPress={() => {
                Alert.alert('Compelete is yet to be completed.')
                item.status = 'done';
                item.image = '';
                item.client_notes = '';
                axios.defaults.headers.common['Authorization'] = `Bearer ${user.token}`;
                axios.put(`/api/tasks/${item.id}`, item)
                .then(response => {
                  console.log(response.data);
                  setTasks(response.data);
                  console.log(tasks);
                })
                .catch(error => {
                  console.log(error.response);
                })
              }}/>
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
    <Center>
      <Text>No tasks at the moment.</Text>
    </Center>
    );
}

export const HomeStack: React.FC<HomeStackProps> = ({}) => {
  const { logout } = useContext(AuthContext);
  return (
    <Stack.Navigator initialRouteName="Feed">
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
        component={Feed}
      />
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
      minHeight: 60,
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
  separator: {
    marginVertical: 30,
    height: 1,
    width: '80%',
  },
});