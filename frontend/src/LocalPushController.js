import PushNotification from 'react-native-push-notification'

PushNotification.configure({
  // (required) Called when a remote or local notification is opened or received
  onNotification: function(notification) {
    console.log('LOCAL NOTIFICATION ==>', notification)
  },
popInitialNotification: true,
  requestPermissions: true
})

PushNotification.createChannel(
    {
      channelId: "gopsi-channel-id", // (required)
      channelName: "Gopsi channel", // (required)
      channelDescription: "A channel to categorise gopsi notifications", // (optional) default: undefined.
      playSound: true, // (optional) default: true
      soundName: "default", // (optional) See `soundName` parameter of `localNotification` function
      importance: 4, // (optional) default: 4. Int value of the Android notification importance
      vibrate: true, // (optional) default: true. Creates the default vibration patten if true.
    },
    (created) => console.log(`createChannel returned '${created}'`) // (optional) callback returns whether the channel was created, false means it already existed.
  );

export const LocalNotification = (task_title, task_desc) => {
  PushNotification.localNotification({
	channelId: "gopsi-channel-id",
    autoCancel: true,
    bigText: task_desc,
    subText: 'Reminder for Gopsi task',
    title: 'Time for Gopsi task!',
    message: task_title,
    vibrate: true,
    vibration: 300,
    playSound: true,
    soundName: 'default',
    actions: '[]'
  })
}

export const CancelLocalNotifications = () => {
  PushNotification.cancelAllLocalNotifications();
}

export const ScheduleLocalNotification = (task_id, task_title, task_desc) => {
  PushNotification.localNotificationSchedule({
	id: task_id,
	channelId: "gopsi-channel-id",
    autoCancel: true,
	date: new Date(Date.now() + 24 * 60 * 60 * 1000), // in 24 hours
    bigText: task_desc,
    subText: 'Reminder for Gopsi task',
    title: 'Time for Gopsi task!',
    message: task_title,
    vibrate: true,
    vibration: 300,
    playSound: true,
    soundName: 'default',
    actions: '[]'
  })
}