import { Component, OnInit } from '@angular/core';
import { ModalController } from '@ionic/angular';
import { GlobalVar } from 'src/app/services/GlobalVar';
import { Profile } from '../../interfaces/interface';
import { DataService } from '../../services/data.service';
import { EditProfilePage } from '../edit-profile/edit-profile.page';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.page.html',
  styleUrls: ['./profile.page.scss'],
})
export class ProfilePage implements OnInit {

  profile: Profile = new Profile();
  data: string[] = [];

  constructor( private modalController: ModalController, 
               private dataService: DataService, 
               private global: GlobalVar ) { }

  ngOnInit() {
    this.loadProfile();
  }

  loadProfile() {
    this.dataService.getProfile( this.global ).subscribe( resp => {   
      this.profile['nomAlumne'] = resp['nomAlumne'];
      this.profile.grup = resp['grup'];
      this.profile.tutorGrup = resp['tutorGrup'];
      this.profile.tutor1 = resp['tutor1'];
      this.profile.tutor2 = resp['tutor2'];
      this.profile.municipi = resp['municipi'];
      this.profile.codi_postal = resp['codi_postal'];
      this.profile.direccio = resp['direccio'];
      this.profile.usuaris = resp['usuaris'] ;
      this.profile.imagen = resp['foto'];
    });
  }

  async editProfile() {
    const modal = await this.modalController.create({
      component: EditProfilePage,
      componentProps: {
        user: this.profile
      }
    });
    await modal.present();

    const { data } = await modal.onDidDismiss();
    
    this.data[0] = (data.users.address==="") ? '-1' : data.users.address;
    this.data[1] = (data.users.village==="") ? '-1' : data.users.village;
    this.data[2] = (data.users.postalCode==="") ? '-1' : data.users.postalCode;
    this.data[3] = (data.users.user1==="") ? '-1' : data.users.user1;
    this.data[4] = (data.users.phone1==="") ? '-1' : data.users.phone1;
    this.data[5] = (data.users.email1==="") ? '-1' : data.users.email1;

    this.dataService.updateUser( this.data, this.global ).subscribe( resp => {
      this.loadProfile();
    });
  }
}


  

  
