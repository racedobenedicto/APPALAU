import { Component, OnInit } from '@angular/core';
import { NgForm } from '@angular/forms';
import { NavController } from '@ionic/angular';
import { GlobalVar } from 'src/app/services/GlobalVar';
import { DataService } from '../../services/data.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.page.html',
  styleUrls: ['./login.page.scss'],
})
export class LoginPage implements OnInit {

  user = {
    user: '',
    password: ''
  }

  error: string;
  
  constructor( private dataService: DataService, 
               private global: GlobalVar,
               private navCtrl: NavController ) { }

  ngOnInit() {
  }

  async login( form: NgForm) {
    await this.dataService.login( this.user.user, this.user.password, this.global.idOneSignal ).subscribe( resp => {
      if(resp['ok']===true){
        this.global.setIdUser(resp['idUser']);
        this.global.setPerfil(resp['perfil']);
        this.global.setToken(resp['token']);
        this.navCtrl.navigateRoot('home', {animated: true});
      }else{
        this.error = "Usuari o contrasenya incorrectes";
      }
    });
  }
}
