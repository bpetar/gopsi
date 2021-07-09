import React, { useContext, useRef, useState, useEffect } from "react";
import { createStackNavigator } from "@react-navigation/stack";
import { Text, Modal, TouchableOpacity, Button, StyleSheet, TextInput, RefreshControl, ScrollView, View, Pressable, Alert } from "react-native";
import { AuthContext } from "./AuthProvider";
import Card from '../components/Card';
import axios from 'axios';

const defaultTasks = [];

const Stack = createStackNavigator();

function Feed() {

  const { user } = useContext(AuthContext);
  const [tasks, setTasks] = useState(defaultTasks);
  const [refreshing, setRefreshing] = useState(false);
  const [inputka, setInputka] = useState("evo");
  const [textChanged, setTextChanged] = useState(false);
  const [modalVisible, setModalVisible] = useState(false);
  const [modalItem, setModalItem] = useState(null);
  const [modalNotes, setModalNotes] = useState(null);

  function pullTasks() {
    console.log('pullTasks');
    setRefreshing(true);
    axios.defaults.headers.common['Authorization'] = `Bearer ${user.token}`;
    axios.defaults.timeout = 1000;
    axios.get(`/api/tasks/${user.id}`)
    .then(response => {
      console.log('pera1 ' + response.data);
      setTasks(response.data);
      console.log(tasks);
      setRefreshing(false);
    })
    .catch(exception => {
      console.log(exception.message);
      setRefreshing(false);
      Alert.alert(
        "Failed to fetch data from server!",
        "Network error: " + exception.message,
        [{text: 'Ok'}],
        {cancelable: true})
    })
    console.log('pullTasks emd');
  }

  function uploadNotes() {
    console.log('onNotesBlur ' + modalItem.id);
    console.log('onNotesBlur ' + modalNotes);
    //item.image = '';
    
    for (let task of tasks) {
      if (task.id == modalItem.id) {
        task.client_notes = modalNotes;
      }
    }

    axios.defaults.headers.common['Authorization'] = `Bearer ${user.token}`;
    axios.put(`/api/tasks/${modalItem.id}`, modalItem)
    .then(response => {
      console.log('onNotesBlur api response ' + response.data);
    })
    .catch(error => {
      console.log(error.response);
    })
  }

  function showModalNotes(item) {
    console.log("show odal : " + item.id);
    setModalItem(item);
    setModalVisible(!modalVisible)
  }

  const onRefresh = React.useCallback(() => {
    
    //wait(2000).then(() => setRefreshing(false));
    console.log('refreshing');
    pullTasks();
  }, []);

  useEffect(pullTasks, []);

  if (tasks.length > 0)
    return (

      <ScrollView keyboardShouldPersistTaps={true} refreshControl={<RefreshControl refreshing={refreshing} onRefresh={onRefresh}/>}>

        <Modal onBackdropPress={() => this.setState({ isVisible: false })} animationType="slide" transparent={true} visible={modalVisible} onRequestClose={() => {
            console.log("Modal has been closed.");
            setModalVisible(!modalVisible);
          }}>
          <View style={styles.centeredView}>
            <View style={styles.modalView}>
              <Text style={styles.modalText}>My Notes</Text>
              <TextInput style={{color: 'gray', borderColor: '#c1d1c1', padding: 10, borderWidth: 1}}
              defaultValue={modalItem ? modalItem.client_notes : "My notes..."} multiline
              numberOfLines={6} onChangeText={text => setModalNotes(text)}/>

              <View style={{ padding: 10, marginTop: 10, flexDirection:"row", justifyContent: "center", alignItems: "center"}}>
                <Pressable style={[styles.button, styles.buttonClose]} onPress={() => setModalVisible(!modalVisible)}>
                  <Text style={styles.buttonTextStyle}> Cancel </Text>
                </Pressable>
                <Pressable style={[styles.button, styles.buttonClose]} onPress={() => {setModalVisible(!modalVisible); uploadNotes()}}>
                  <Text style={styles.buttonTextStyle}> Save </Text>
                </Pressable>
              </View>
            </View>
          </View>
        </Modal>

        <View style={styles.container}>
          {tasks.map((item) => (
            <Card key={item.id} style={styles.card}> 
              <Text style={styles.title}>{item.title}</Text>
              <Text style={styles.description}>{item.description}</Text>

              <Text style={styles.client_notes} onPress={() => showModalNotes(item)}>{item.client_notes ? item.client_notes : "(Tap here to enter notes)"}</Text>

              <Button color="#91c49f" title={ item.repeat > 0 ? "Complete " + item.counter + "/" + item.repeat : "Complete"}
                onPress={() => {
                  if (item.repeat == 0 || item.repeat <= item.counter + 1) {
                    item.status = 'done';
                    item.image = '';
                    //item.client_notes = '';
                    axios.defaults.headers.common['Authorization'] = `Bearer ${user.token}`;
                    axios.put(`/api/tasks/${item.id}`, item)
                    .then(response => {
                      console.log('pera3 ' + response.data);
                      //setTasks(response.data);
                      pullTasks(); //refresh the list
                      console.log(response.data);
                      console.log(tasks);
                    })
                    .catch(error => {
                      console.log(error.response);
                    })
                  } else {
                    item.counter++;
                    item.image = '';
                    axios.defaults.headers.common['Authorization'] = `Bearer ${user.token}`;
                    axios.put(`/api/tasks/${item.id}`, item)
                    .then(response => {
                      console.log('item counter goes up ' + response.data);
                      pullTasks(); //refresh the list
                      console.log(response.data);
                      console.log(tasks);
                    })
                    .catch(error => {
                      console.log(error.response);
                    })
                  }
                }}/>
            </Card>
          ))}

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

export const HomeStack = () => {
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
  client_notes: {
    fontSize: 14,
    fontWeight: 'normal',
    padding: 10,
    color: '#56a656',
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

  centeredView: {
    flex: 1,
    justifyContent: "center",
    alignItems: "center",
    marginTop: 2
  },
  modalView: {
    margin: 2,
    width: "90%",
    backgroundColor: "white",
    borderRadius: 20,
    padding: 15,
    alignItems: 'stretch',
    shadowColor: "#000",
    shadowOffset: {
      width: 0,
      height: 2
    },
    shadowOpacity: 0.25,
    shadowRadius: 4,
    elevation: 5
  },
  button: {
    borderRadius: 20,
    marginLeft: 10,
    marginRight: 10,
    padding: 10,
    elevation: 2
  },
  buttonClose: {
    backgroundColor: "#2196F3",
  },
  textStyle: {
    color: "white",
    fontWeight: "bold",
    textAlign: "center"
  },
  buttonTextStyle: {
    marginLeft: 10,
    marginRight: 10,
    color: "white",
    fontWeight: "bold",
    textAlign: "center"
  },
  modalText: {
    marginBottom: 15,
    textAlign: "center"
  }

});