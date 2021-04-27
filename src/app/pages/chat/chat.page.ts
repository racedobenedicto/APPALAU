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
      this.messages=[];
      setTimeout(()=>{this.applicationRef.tick();},100);
      this.loadMsg();
      setTimeout(()=>{this.applicationRef.tick();},500);
      setTimeout(()=>{this.scrollToBottom();},700);
    });
  }

  ngOnInit() {
    this.loadMsg();
  }

  ionViewDidEnter(){
    this.scrollToBottom();
  }

  send( subject: string, form: NgForm ) {
    console.log(subject, this.message);
    this.dataService.sendMsg( subject, this.message, this.global ).subscribe( resp => {
      this.loadMsg();
      this.message = '';
    });
  }

  closeChat() {
    this.modalController.dismiss();
  }

  loadMsg() {
    this.dataService.getMsg( this.subject['materia'], this.global ).subscribe( resp => {
      
      this.messages.push(...resp);
      //this.messages = resp;  
      console.log("Recarga msg", this.messages);  
      setTimeout(()=>{this.scrollToBottom();},250);
    });
    
  }
 
  scrollToBottom() {
    (this.content).scrollToBottom();
  }
}
