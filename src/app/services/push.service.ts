import { EventEmitter, Injectable } from '@angular/core';
import { OneSignal, OSNotificationPayload } from '@ionic-native/onesignal/ngx';
import { GlobalVar } from 'src/app/services/GlobalVar';

@Injectable({
  providedIn: 'root'
})
export class PushService {

  pushListener = new EventEmitter<OSNotificationPayload>();

  constructor( private oneSignal: OneSignal, private global: GlobalVar ) { }

  configuracionInicial(){
    this.oneSignal.startInit('9b3566eb-03b3-4fbc-8212-c1f889bf7d26', '882916830504');

    this.oneSignal.inFocusDisplaying(this.oneSignal.OSInFocusDisplayOption.Notification);

    this.oneSignal.handleNotificationReceived().subscribe((noti) => {
      // do something when notification is received
      this.pushListener.emit(noti.payload);
      console.log("Notificación recibida:", noti);
    });

    this.oneSignal.handleNotificationOpened().subscribe((noti) => {
      // do something when a notification is opened
      console.log("Notificación abierta:", noti);
    });

    //Id Subscriptor
    this.oneSignal.getIds().then( info =>{
      this.global.setIdOnesignal(info.userId);
      //console.log("UserId OneSignal:", info.userId);
    });

    this.oneSignal.endInit();
  }
}
