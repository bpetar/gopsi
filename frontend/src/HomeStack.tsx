import React, { useContext, useRef, useState, useEffect } from "react";
import { createStackNavigator } from "@react-navigation/stack";
import { Center } from "./Center";
import { Text, TouchableOpacity, FlatList, Button, StyleSheet, TextInput, ScrollView, View, Pressable, Alert } from "react-native";
import { AuthContext } from "./AuthProvider";
import { HomeParamList, HomeStackNavProps } from "./HomeParamList";
import Card from '../components/Card';

interface HomeStackProps {}

const Stack = createStackNavigator<HomeParamList>();

function Feed({ navigation }: HomeStackNavProps<"Feed">) {
  return (
    <ScrollView>
    <View style={styles.container}>
      <Card style={styles.card}> 
        <Text style={styles.title}>Moj prvi card task</Text>
        <Text style={styles.description}>Prvi card task ima malo duzi description koji prelazi u dva reda.</Text>
        <TextInput style={{color: 'gray', borderColor: '#c1d1c1', padding: 10, borderWidth: 1}}
        defaultValue="My notes..."
        />
        <Button color="#91c49f" title="Complete" onPress={() => Alert.alert('Complete is yet to be completed.')}/>
      </Card>
      <Card style={styles.card}> 
        <Text style={styles.title}>Moj drugi card task</Text>
        <Text style={styles.description}>Drugi card task ima isto malo duzi description koji prelazi u dva reda, a mozda i tri, cetiri. Za promenu.</Text>
        <TextInput style={{ color: 'gray', borderColor: '#c1d1c1', padding: 10, borderWidth: 1}}
        defaultValue="My notes..."
        />
        <Button color="#91c49f" title="Complete" onPress={() => Alert.alert('Complete is yet to be completed.')}/>
      </Card>
      <Card style={styles.card}> 
        <Text style={styles.title}>Moj cetvrti card task</Text>
        <Text style={styles.description}>Drugi card task ima isto malo duzi description koji prelazi u dva reda, a mozda i tri, cetiri. Za promenu.</Text>
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

      </Card>
    </View>
    </ScrollView>
    /*<Center>
      <Text>No tasks at the moment.</Text>
    </Center>*/
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