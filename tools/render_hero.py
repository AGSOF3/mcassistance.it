"""Render an original, illustrative robotic finishing cell with Blender 4.3+.
blender -b -t 8 --python tools/render_hero.py -- --output /tmp/mc-hero-frames
Use --still to render a single preview. See docs/HERO-VIDEO.md for encoding.
This is a concept animation, not a technical reconstruction of an MC installation.
"""
import bpy, math, sys, argparse
from mathutils import Vector
args=sys.argv[sys.argv.index('--')+1:] if '--' in sys.argv else []
p=argparse.ArgumentParser();p.add_argument('--output',default='/tmp/mc-hero-frames');p.add_argument('--still',action='store_true');p.add_argument('--engine',choices=['BLENDER_EEVEE_NEXT','BLENDER_WORKBENCH'],default='BLENDER_EEVEE_NEXT');p.add_argument('--samples',type=int,default=4);p.add_argument('--end',type=int,default=144);p.add_argument('--step',type=int,default=1);a=p.parse_args(args)
bpy.ops.object.select_all(action='SELECT');bpy.ops.object.delete(use_global=False)
scene=bpy.context.scene
scene.render.engine=a.engine
if a.engine=='BLENDER_WORKBENCH':
 scene.display.shading.light='STUDIO';scene.display.shading.color_type='MATERIAL';scene.display.shading.show_shadows=True;scene.display.shading.show_cavity=True;scene.display.shading.cavity_type='BOTH';scene.display.shading.background_type='WORLD'
else:scene.eevee.taa_render_samples=a.samples
scene.render.resolution_x=1920;scene.render.resolution_y=1080;scene.render.resolution_percentage=100
scene.render.image_settings.file_format='PNG';scene.render.fps=24
scene.render.threads_mode='FIXED';scene.render.threads=8
scene.world.color=(.08,.08,.08)
scene.view_settings.view_transform='AgX'
def mat(name,color,metal=0,rough=.4,emission=0):
 m=bpy.data.materials.new(name);m.diffuse_color=(*color,1);m.use_nodes=True;bs=m.node_tree.nodes.get('Principled BSDF');bs.inputs['Base Color'].default_value=(*color,1);bs.inputs['Metallic'].default_value=metal;bs.inputs['Roughness'].default_value=rough
 if emission:bs.inputs['Emission Color'].default_value=(*color,1);bs.inputs['Emission Strength'].default_value=emission
 return m
white=mat('Ceramic white / robot shell',(.65,.7,.66),.45,.28);dark=mat('Graphite structure',(.035,.05,.043),.7,.32);rubber=mat('Joint boots',(.012,.019,.016),.2,.5);metal=mat('Machined aluminium',(.43,.5,.48),.85,.24);lime=mat('Safety lime',(.55,.8,.16),.3,.35);glow=mat('Status light',(.53,.85,.12),.1,.3,3);floor=mat('Factory floor',(.026,.035,.03),.25,.5);grid=mat('CAD floor markings',(.085,.12,.09),.3,.6);bronze=mat('Abrasive wheel',(.26,.19,.10),.65,.4);screen=mat('Controller display',(.12,.29,.19),.3,.25,1.0)
def finish(o,name,m,bevel=0):
 o.name=name;o.data.materials.append(m)
 if bevel:
  mod=o.modifiers.new('Machined edge radius','BEVEL');mod.width=bevel;mod.segments=3
  o.modifiers.new('Weighted surface normals','WEIGHTED_NORMAL')
 return o
def box(name,loc,size,m,bevel=.04):
 bpy.ops.mesh.primitive_cube_add(size=1,location=loc);o=bpy.context.object;o.dimensions=size;bpy.ops.object.transform_apply(location=False,rotation=False,scale=True);return finish(o,name,m,bevel)
def cyl(name,loc,radius,depth,m,axis=(0,0,1)):
 bpy.ops.mesh.primitive_cylinder_add(vertices=40,radius=radius,depth=depth,location=loc);o=bpy.context.object;o.rotation_mode='QUATERNION';o.rotation_quaternion=Vector(axis).to_track_quat('Z','Y')
 for f in o.data.polygons:f.use_smooth=True
 return finish(o,name,m,.018)
def sphere(name,loc,radius,m):
 bpy.ops.mesh.primitive_uv_sphere_add(segments=24,ring_count=12,radius=radius,location=loc);o=bpy.context.object
 for f in o.data.polygons:f.use_smooth=True
 return finish(o,name,m)
def text(name,value,loc,size,m,rot=(0,0,0)):
 cu=bpy.data.curves.new(name,'FONT');cu.body=value;cu.size=size;cu.extrude=.0005;o=bpy.data.objects.new(name,cu);scene.collection.objects.link(o);o.location=loc;o.rotation_euler=rot;o.data.materials.append(m);return o
box('Ground',(0,0,-.16),(200,200,.2),floor)
for i in range(-14,15):
 box('Floor grid X',(i,0,-.052),(.008,28,.002),grid,0);box('Floor grid Y',(0,i,-.052),(28,.008,.002),grid,0)
box('Cell foundation',(2.1,.0,.02),(6,4.3,.12),dark)
for y in [-2.12,2.12]:box('Perimeter floor marking',(2.1,y,.087),(6,.025,.005),lime,0)
for x in [-.9,5.1]:box('Perimeter floor marking',(x,0,.087),(.025,4.3,.005),lime,0)
# Back safety enclosure, spaced so the arm and wheel remain clearly visible.
for x in [-.8,1.2,3.2,5.05]:
 box('Safety frame post',(x,1.93,1.55),(.065,.065,2.9),dark,.008)
 cyl('Post cap',(x,1.93,3.02),.045,.05,lime)
for z in [.35,1.5,3.0]:box('Enclosure rail',(2.1,1.93,z),(6,.045,.045),metal,.008)
for x in [i*.16-.75 for i in range(37)]:box('Guard mesh wire',(x,1.935,1.62),(.007,.007,2.7),dark,0)
for z in [i*.18+.35 for i in range(15)]:box('Guard mesh wire',(2.1,1.937,z),(5.8,.006,.006),dark,0)
# Pedestal, mounting plate and articulated industrial arm.
box('Robot pedestal',(1.3,0,.35),(1.1,1.05,.55),white)
box('Robot foot plate',(1.3,0,.12),(1.35,1.25,.1),metal)
for x in [.85,1.75]:
 for y in [-.4,.4]:cyl('Anchor bolt',(x,y,.2),.055,.08,dark)
cyl('Slew bearing',(1.3,0,.7),.42,.24,dark);cyl('Base shell',(1.3,0,.87),.34,.3,white)
cyl('Lime joint ring',(1.3,0,1.03),.35,.045,lime)
shoulder=Vector((1.3,0,1.25))
upper=box('Upper arm',(0,0,0),(.43,.48,1),white,.1)
fore=box('Forearm',(0,0,0),(.32,.36,1),white,.08)
upper_inset=box('Upper arm inset',(0,0,0),(.08,.5,.8),dark,.02)
elbow_joint=cyl('Elbow motor',(0,0,0),.31,.55,dark,(0,1,0));elbow_cap=cyl('Elbow cap',(0,0,0),.25,.58,metal,(0,1,0));elbow_ring=cyl('Elbow status ring',(0,0,0),.26,.6,lime,(0,1,0))
shoulder_motor=cyl('Shoulder motor',shoulder,.33,.58,dark,(0,1,0));cyl('Shoulder cover',shoulder,.26,.62,white,(0,1,0))
wrist_joint=sphere('Wrist assembly',(0,0,0),.24,dark);wrist_shell=cyl('Wrist flange',(0,0,0),.18,.28,metal,(1,0,0))
gripper=box('End effector',(0,0,0),(.32,.27,.22),dark)
fingers=[box('Gripper finger',(0,0,0),(.4,.055,.08),metal,.015) for _ in range(2)]
part=cyl('Held workpiece',(0,0,0),.13,.38,metal,(1,0,0))
# Dedicated finishing station with a visible vertical wheel.
box('Finishing machine base',(4.2,.0,.45),(1.15,1.4,.7),white)
box('Motor housing',(4.2,.55,1.65),(.95,.8,1.55),dark,.1)
cyl('Spindle',(4.2,.05,2.08),.15,1,metal,(0,1,0))
wheel=cyl('Polishing wheel',(4.2,-.22,2.08),.82,.28,bronze,(0,1,0));cyl('Wheel hub',(4.2,-.4,2.08),.17,.07,metal,(0,1,0))
# Rotating wheel face divisions make motion readable without flashing.
wheel_marks=[]
for i in range(8):
 th=i*math.tau/8;ob=box('Wheel face segment',(4.2+.6*math.cos(th),-.368,2.08+.6*math.sin(th)),(.24,.008,.015),metal,.003);wheel_marks.append((ob,th))
box('Machine panel',(4.55,-.715,.69),(.32,.015,.2),dark,.01)
# Workpiece conveyor / rollers in the front-left of the cell.
box('Conveyor frame',(.0,-1.1,.78),(1.5,2.5,.16),dark)
for x in [-.63,.63]:
 for y in [-2.12,-.08]:box('Conveyor leg',(x,y,.43),(.08,.08,.65),metal,.008)
for i in range(14):cyl('Conveyor roller',(0,-2.23+i*.17,.9),.065,1.32,metal,(1,0,0))
for y in [-1.9,-1.35,-.8]:
 box('Workpiece pallet',(0,y,1.01),(.62,.4,.045),dark,.01)
 cyl('Round workpiece',(0,y,1.11),.16,.14,metal)
# HMI cabinet, emergency stop and status tower.
box('Control cabinet',(-.55,1.15,1.05),(.72,.55,1.8),white)
box('Operator screen',(-.55,.864,1.5),(.53,.025,.4),dark,.02)
box('Screen display',(-.55,.844,1.5),(.44,.006,.3),screen,.005)
for z in [1.45,1.51,1.57]:box('Display line',(-.58,.837,z),(.27,.002,.008),lime,0)
cyl('E stop',(-.75,.83,1.12),.05,.025,mat('E stop red',(.5,.025,.015)),(0,1,0))
cyl('Signal tower mast',(-.55,1.15,2.12),.025,.35,metal)
cyl('Green status lamp',(-.55,1.15,2.34),.055,.18,glow)
text('Cell floor label','ROBOTIC FINISHING / CONCEPT',(.1,-2.0,.097),.13,metal)
# Dramatic studio lighting, no external textures or scene assets.
def area(name,loc,energy,color,size,target):
 ld=bpy.data.lights.new(name,'AREA');ld.energy=energy;ld.color=color;ld.shape='DISK';ld.size=size;o=bpy.data.objects.new(name,ld);scene.collection.objects.link(o);o.location=loc;o.rotation_euler=(Vector(target)-o.location).to_track_quat('-Z','Y').to_euler()
area('Key softbox',(2,-5,8),2200,(.85,.94,1),7,(2,0,1))
area('Lime rim',(4,4,6),1800,(.66,.85,.40),5,(2,0,1.7))
area('Left fill',(-4,0,4),900,(.65,.75,.85),5,(1,0,1))
area('Wheel edge',(8,-1,4),1600,(1,.85,.66),4,(4,0,2))
cam_data=bpy.data.cameras.new('Hero camera');camera=bpy.data.objects.new('Hero camera',cam_data);scene.collection.objects.link(camera);scene.camera=camera
camera.location=(10,-14,10);target=Vector((.1,0,1.2));camera.rotation_euler=(target-camera.location).to_track_quat('-Z','Y').to_euler();cam_data.type='ORTHO';cam_data.ortho_scale=12.2;cam_data.lens=45
# A continuous 6-second loop. The final duplicate pose is not encoded.
scene.frame_start=1;scene.frame_end=a.end;scene.frame_step=a.step
for f in range(1,146):
 th=(f-1)/144*math.tau
 elbow=Vector((1.8+.12*math.sin(th),.15+.15*math.sin(th),2.95+.09*math.cos(th)))
 wrist=Vector((3.2+.08*math.sin(th),-.25+.15*math.sin(th),2.2+.12*math.cos(th)))
 for ob,start,end,width in [(upper,shoulder,elbow,1),(fore,elbow,wrist,1)]:
  vec=end-start;ob.location=(start+end)/2;ob.rotation_mode='QUATERNION';ob.rotation_quaternion=vec.to_track_quat('Z','Y');ob.scale.z=vec.length
  for prop in ['location','rotation_quaternion','scale']:ob.keyframe_insert(prop,frame=f)
 upper_inset.location=upper.location+Vector((0,-.02,0));upper_inset.rotation_mode='QUATERNION';upper_inset.rotation_quaternion=upper.rotation_quaternion
 upper_inset.keyframe_insert('location',frame=f);upper_inset.keyframe_insert('rotation_quaternion',frame=f)
 for ob in [elbow_joint,elbow_cap,elbow_ring]:ob.location=elbow;ob.keyframe_insert('location',frame=f)
 for ob,offset in [(wrist_joint,(0,0,0)),(wrist_shell,(.18,0,0)),(gripper,(.38,0,0)),(fingers[0],(.6,-.12,0)),(fingers[1],(.6,.12,0)),(part,(.65,0,0))]:ob.location=wrist+Vector(offset);ob.keyframe_insert('location',frame=f)
 for ob,start_th in wheel_marks:
  angle=start_th+th;ob.location=(4.2+.6*math.cos(angle),-.368,2.08+.6*math.sin(angle));ob.rotation_euler.y=-angle;ob.keyframe_insert('location',frame=f);ob.keyframe_insert('rotation_euler',frame=f)
for ob in bpy.data.objects:
 if ob.animation_data and ob.animation_data.action:
  for fc in ob.animation_data.action.fcurves:
   for key in fc.keyframe_points:key.interpolation='LINEAR'
scene.frame_set(1)
if a.still:
 scene.render.filepath=a.output+'/preview.png';bpy.ops.render.render(write_still=True)
else:
 scene.render.filepath=a.output+'/frame-';bpy.ops.render.render(animation=True)
