import { ApplicationRef, Component, Input, OnInit, ViewChild } from '@angular/core';
import { NgForm } from '@angular/forms';
import { IonContent, ModalController } from '@ionic/angular';
import { DataService } from 'src/app/services/data.service';
import { PushService } from 'src/app/services/push.service';
import { GlobalVar } from '../../services/GlobalVar';
import { Msg } from 'src/app/interfaces/interface';
import { ChatHomePage } from '../chat-home/chat-home.page';


@Component({
  selector: 'app-chat',
  templateUrl: './chat.page.html',
  styleUrls: ['./chat.page.scss'],
})
export class ChatPage implements OnInit {

  messages: Msg[] = [];
  @Input() subject: string[];
  @Input() message: string;
  @ViewChild(IonContent, { static: true }) content: IonContent;
  
  constructor( private modalController: ModalController, 
               private dataService: DataService, 
               public global: GlobalVar,
               public pushService: PushService,
             private applicationRef: ApplicationRef 
              ) { 
    this.pushService.pushListener.subscribe(noti => {
      setTimeout(async ()=>{this.applicationRef.tick();},100);
      this.loadMsg("noLlegits");
      setTimeout(()=>{
        this.applicationRef.tick();
        setTimeout(()=>{this.scrollToBottom();},100);
      },700);
    });
  }

  ngOnInit() {
    this.loadMsg("tots");
  }

  ionViewDidEnter(){
    this.scrollToBottom();
  }

  send( subject: string, form: NgForm ) {
    console.log(subject, this.message);
    this.dataService.sendMsg( subject, this.message, this.global ).subscribe( resp => {
      this.loadMsg("noLlegits");
      this.message = '';
    });
  }

  closeChat() {
    this.modalController.dismiss();
  }

  loadMsg(tipus: string) {
    this.dataService.getMsg( this.subject['materia'], this.global, tipus ).subscribe( resp => {
      this.messages.push(...resp); 
      console.log("Recarga msg", this.messages);  
      setTimeout(()=>{this.scrollToBottom();},250);
    });  
  }
 
  scrollToBottom() {
    (this.content).scrollToBottom();
  }
}
