import { Component, Input, OnInit, Output } from '@angular/core';
import { PopoverController } from '@ionic/angular';
import { JustifyComponent } from '../justify/justify.component';
import { DataService } from '../../services/data.service';
import { GlobalVar } from '../../services/GlobalVar';

@Component({
  selector: 'app-absences',
  templateUrl: './absences.component.html',
  styleUrls: ['./absences.component.scss'],
})
export class AbsencesComponent implements OnInit {

  @Input() fileAbsences: string[][];
  @Output() dates: string[] = [];
  data: string[] = [];
  
  constructor( private popoverController: PopoverController,
               private dataService: DataService,
               private global: GlobalVar ) { }
               
  ngOnInit() {}

  async justify(ev: any) {
    const popover = await this.popoverController.create({
      component: JustifyComponent,
      event: ev,
      translucent: true,
      backdropDismiss: false,
      componentProps: {
        dates: this.selectDates()
      }
    });
    await popover.present();
    
    const { data } = await popover.onWillDismiss();
    
    this.data[0] = data.item['text'];
    this.data[1] = data.item['date'];
    
    this.dataService.justify( this.data, this.global ).subscribe( resp => {
      this.loadFile();
    });
  }

  selectDates() {
    let i,j, found;
    for(i=0; i<this.fileAbsences.length; i++) {
      j=1;
      found=0;
      while(j<=6 && found===0) {
        if( this.fileAbsences[i]['H'+j] === 'F') {
          found=1;
          this.dates.push(this.fileAbsences[i]['data']);
        }
        j++;
      }
    }
    return this.dates;
  }

  loadFile() {
    this.dataService.getFile( this.global ).subscribe( resp => {
      this.fileAbsences = resp['absencies'];
    });
  }
}
