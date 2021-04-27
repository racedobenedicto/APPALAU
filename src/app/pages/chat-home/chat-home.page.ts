import { Component, OnInit } from '@angular/core';
import { ModalController } from '@ionic/angular';
import { DataService } from 'src/app/services/data.service';
import { GlobalVar } from '../../services/GlobalVar';
import { ChatPage } from '../chat/chat.page';

@Component({
  selector: 'app-chat-home',
  templateUrl: './chat-home.page.html',
  styleUrls: ['./chat-home.page.scss'],
})
export class ChatHomePage implements OnInit {

  subjects: string[][] = [];
  images: string[] = [];

  constructor( private modalController: ModalController,
               private dataService: DataService,
               public global: GlobalVar ) {
    this.images['ANG']='/assets/anglès.jpg';
    this.images['CAT']='/assets/català.jpg';
    this.images['CAST']='/assets/castellà.jpg';
    this.images['DT']='/assets/dibuix.jpg';
    this.images['FIL']='/assets/filosofia.jpg';
    this.images['FIS']='/assets/fisica.jpg';
    this.images['GENERAL']='/assets/general.jpg';
    this.images['HIST']='/assets/historia.jpg';
    this.images['MAT']='/assets/mates.jpg';
    this.images['TEC']='/assets/tecno.jpg';
    this.images['TUT']='/assets/tutoria.png';
  }

  ngOnInit() {
    this.loadChatHome();
  }

  loadChatHome() {
    this.dataService.getChatHome( this.global ).subscribe( resp => {
      console.log(resp);
      this.subjects = resp;
    });
  }

  async openChat( subject: string, images: string ) {
    const modal = await this.modalController.create({
      component: ChatPage,
      componentProps: {
        subject: subject,
        images: images
      }
    });
    await modal.present();

    const { data } = await modal.onDidDismiss();
    this.loadChatHome(); 
  }
}