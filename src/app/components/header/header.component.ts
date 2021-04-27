import { Component, OnInit } from '@angular/core';
import { NavController } from '@ionic/angular';
import { GlobalVar } from '../../services/GlobalVar';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss'],
})
export class HeaderComponent implements OnInit {

  constructor( private navCtrl: NavController,
               private global: GlobalVar ) { }

  ngOnInit() {}

  async logout() {
    this.navCtrl.navigateRoot('login', {animated: true});

    this.global.setIdUser("");
    this.global.setPerfil("");
    this.global.setToken("");
  }
}
